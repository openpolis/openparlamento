<?php
/**
 * @copyright Copyright 2007 Conduit Internet Technologies, Inc. (http://conduit-it.com)
 * @license Apache Licence, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package Apache
 * @subpackage Solr
 * @author Donovan Jimenez <djimenez@conduit-it.com>
 */

require_once('Apache/Solr/Document.php');
require_once('Apache/Solr/Response.php');

/**
 * Starting point for the Solr API. Represents a Solr server resource and has
 * methods for pinging, adding, deleting, committing, optimizing and searching.
 *
 * Example Usage:
 * <code>
 * ...
 * $solr = new Apache_Solr_Service(); //or explicitly new Apache_Solr_Service('localhost', 8180, '/solr')
 *
 * if ($solr->ping())
 * {
 * 		$solr->deleteByQuery('*:*'); //deletes ALL documents - be careful :)
 *
 * 		$document = new Apache_Solr_Document();
 * 		$document->id = uniqid(); //or something else suitably unique
 *
 * 		$document->title = 'Some Title';
 * 		$document->content = 'Some content for this wonderful document. Blah blah blah.';
 *
 * 		$solr->addDocument($document); 	//if you're going to be adding documents in bulk using addDocuments
 * 										//with an array of documents is faster
 *
 * 		$solr->commit(); //commit to see the deletes and the document
 * 		$solr->optimize(); //merges multiple segments into one
 *
 * 		//and the one we all care about, search!
 * 		//any other common or custom parameters to the request handler can go in the
 * 		//optional 4th array argument.
 * 		$solr->search('content:blah', 0, 10, array('sort' => 'timestamp desc'));
 * }
 * ...
 * </code>
 *
 * @todo Investigate using other HTTP clients other than file_get_contents built-in handler. Could provide performance
 * improvements when dealing with multiple requests by using HTTP's keep alive functionality
 */
class Apache_Solr_Service
{
	/**
	 * Response version we support
	 */
	const SOLR_VERSION = '1.2';

	/**
	 * Response writer we support
	 *
	 * @todo Solr 1.3 release may change this to SerializedPHP or PHP implementation
	 */
	const SOLR_WRITER = 'json';

	/**
	 * NamedList Treatment constants
	 */
	const NAMED_LIST_FLAT = 'flat';
	const NAMED_LIST_MAP = 'map';

	/**
	 * Servlet mappings
	 */
	const PING_SERVLET = 'admin/ping';
	const UPDATE_SERVLET = 'update';
	const SEARCH_SERVLET = 'select';
	const THREADS_SERVLET = 'admin/threads';

	/**
	 * Server identification strings
	 *
	 * @var string
	 */
	protected $_host, $_port, $_path;

	/**
	 * Whether {@link Apache_Solr_Response} objects should create {@link Apache_Solr_Document}s in
	 * the returned parsed data
	 *
	 * @var boolean
	 */
	protected $_createDocuments = true;

	/**
	 * Whether {@link Apache_Solr_Response} objects should have multivalue fields with only a single value
	 * collapsed to appear as a single value would.
	 *
	 * @var boolean
	 */
	protected $_collapseSingleValueArrays = true;

	/**
	 * How NamedLists should be formatted in the output.  This specifically effects facet counts. Valid values
	 * are {@link Apache_Solr_Service::NAMED_LIST_MAP} (default) or {@link Apache_Solr_Service::NAMED_LIST_FLAT}.
	 *
	 * @var string
	 */
	protected $_namedListTreatment = self::NAMED_LIST_MAP;

	/**
	 * Query delimiters. Someone might want to be able to change
	 * these (to use &amp; instead of & for example), so I've provided them.
	 *
	 * @var string
	 */
	protected $_queryDelimiter = '?', $_queryStringDelimiter = '&';

	/**
	 * Constructed servlet full path URLs
	 *
	 * @var string
	 */
	protected $_updateUrl, $_searchUrl, $_threadsUrl;

	/**
	 * Keep track of whether our URLs have been constructed
	 *
	 * @var boolean
	 */
	protected $_urlsInited = false;

	/**
	 * Stream context for posting
	 *
	 * @var resource
	 */
	protected $_postContext;

	/**
	 * Escape a value for special query characters such as ':', '(', ')', '*', '?', etc.
	 *
	 * NOTE: inside a phrase fewer characters need escaped, use {@link Apache_Solr_Service::escapePhrase()} instead
	 *
	 * @param string $value
	 * @return string
	 */
	static public function escape($value)
	{
		//list taken from http://lucene.apache.org/java/docs/queryparsersyntax.html#Escaping%20Special%20Characters
		$pattern = '/(\+|-|&&|\|\||!|\(|\)|\{|}|\[|]|\^|"|~|\*|\?|:|\\\)/';
		$replace = '\\\$1';

		return preg_replace($pattern, $replace, $value);
	}

	/**
	 * Escape a value meant to be contained in a phrase for special query characters
	 *
	 * @param string $value
	 * @return string
	 */
	static public function escapePhrase($value)
	{
		$pattern = '/("|\\\)/';
		$replace = '\\\$1';

		return preg_replace($pattern, $replace, $value);
	}

	/**
	 * Convenience function for creating phrase syntax from a value
	 *
	 * @param string $value
	 * @return string
	 */
	static public function phrase($value)
	{
		return '"' . self::escapePhrase($value) . '"';
	}

	/**
	 * Constructor. All parameters are optional and will take on default values
	 * if not specified.
	 *
	 * @param string $host
	 * @param string $port
	 * @param string $path
	 */
	public function __construct($host = 'localhost', $port = 8180, $path = '/solr/')
	{
		$this->setHost($host);
		$this->setPort($port);
		$this->setPath($path);

		$this->_initUrls();

		//set up the stream context for posting with file_get_contents
		$contextOpts = array(
			'http' => array(
				'method' => 'POST',
				'header' => "Content-Type: text/xml; charset=UTF-8\r\n" //php.net example showed \r\n at the end
			)
		);

		$this->_postContext = stream_context_create($contextOpts);
	}

	/**
	 * Return a valid http URL given this server's host, port and path and a provided servlet name
	 *
	 * @param string $servlet
	 * @return string
	 */
	protected function _constructUrl($servlet, $params = array())
	{
		if (count($params))
		{
			//escape all parameters appropriately for inclusion in the query string
			$escapedParams = array();

			foreach ($params as $key => $value)
			{
				$escapedParams[] = urlencode($key) . '=' . urlencode($value);
			}

			$queryString = $this->_queryDelimiter . implode($this->_queryStringDelimiter, $escapedParams);
		}
		else
		{
			$queryString = '';
		}

		return 'http://' . $this->_host . ':' . $this->_port . $this->_path . $servlet . $queryString;
	}

	/**
	 * Construct the Full URLs for the three servlets we reference
	 */
	protected function _initUrls()
	{
		//Initialize our full servlet URLs now that we have server information
		$this->_updateUrl = $this->_constructUrl(self::UPDATE_SERVLET, array('wt' => self::SOLR_WRITER ));
		$this->_searchUrl = $this->_constructUrl(self::SEARCH_SERVLET);
		$this->_threadsUrl = $this->_constructUrl(self::THREADS_SERVLET, array('wt' => self::SOLR_WRITER ));

		$this->_urlsInited = true;
	}

	/**
	 * Central method for making a get operation against this Solr Server
	 *
	 * @param string $url
	 * @param float $timeout Read timeout in seconds
	 * @return Apache_Solr_Response
	 *
	 * @todo implement timeout ability
	 * @throws Exception If a non 200 response status is returned
	 */
	protected function _sendRawGet($url, $timeout = FALSE)
	{
		//$http_response_header is set by file_get_contents
		$response = new Apache_Solr_Response(@file_get_contents($url), $http_response_header, $this->_createDocuments, $this->_collapseSingleValueArrays);

		if ($response->getHttpStatus() != 200)
		{
			throw new Exception('"' . $response->getHttpStatus() . '" Status: ' . $response->getHttpStatusMessage(), $response->getHttpStatus());
		}

		return $response;
	}

	/**
	 * Central method for making a post operation against this Solr Server
	 *
	 * @param string $url
	 * @param string $rawPost
	 * @param float $timeout Read timeout in seconds
	 * @param string $contentType
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If a non 200 response status is returned
	 */
	protected function _sendRawPost($url, $rawPost, $timeout = FALSE, $contentType = 'text/xml; charset=UTF-8')
	{
		//ensure content type is correct
		stream_context_set_option($this->_postContext, 'http', 'header', 'Content-Type: ' . $contentType);

		//set the read timeout if specified
		if ($timeout !== FALSE)
		{
			stream_context_set_option($this->_postContext, 'http', 'timeout', $timeout);
		}

		//set the content
		stream_context_set_option($this->_postContext, 'http', 'content', $rawPost);

		//$http_response_header is set by file_get_contents
		$response = new Apache_Solr_Response(@file_get_contents($url, false, $this->_postContext), $http_response_header, $this->_createDocuments, $this->_collapseSingleValueArrays);

		if ($response->getHttpStatus() != 200)
		{
			throw new Exception('"' . $response->getHttpStatus() . '" Status: ' . $response->getHttpStatusMessage(), $response->getHttpStatus());
		}

		return $response;
	}

	/**
	 * Returns the set host
	 *
	 * @return string
	 */
	public function getHost()
	{
		return $this->_host;
	}

	/**
	 * Set the host used. If empty will fallback to constants
	 *
	 * @param string $host
	 */
	public function setHost($host)
	{
		//Use the provided host or use the default
		if (empty($host))
		{
			throw new Exception('Host parameter is empty');
		}
		else
		{
			$this->_host = $host;
		}

		if ($this->_urlsInited)
		{
			$this->_initUrls();
		}
	}

	/**
	 * Get the set port
	 *
	 * @return integer
	 */
	public function getPort()
	{
		return $this->_port;
	}

	/**
	 * Set the port used. If empty will fallback to constants
	 *
	 * @param integer $port
	 */
	public function setPort($port)
	{
		//Use the provided port or use the default
		$port = (int) $port;

		if ($port <= 0)
		{
			throw new Exception('Port is not a valid port number');
		}
		else
		{
			$this->_port = $port;
		}

		if ($this->_urlsInited)
		{
			$this->_initUrls();
		}
	}

	/**
	 * Get the set path.
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->_path;
	}

	/**
	 * Set the path used. If empty will fallback to constants
	 *
	 * @param string $path
	 */
	public function setPath($path)
	{
		$path = trim($path, '/');

		$this->_path = '/' . $path . '/';

		if ($this->_urlsInited)
		{
			$this->_initUrls();
		}
	}

	/**
	 * Set the create documents flag. This determines whether {@link Apache_Solr_Response} objects will
	 * parse the response and create {@link Apache_Solr_Document} instances in place.
	 *
	 * @param unknown_type $createDocuments
	 */
	public function setCreateDocuments($createDocuments)
	{
		$this->_createDocuments = (bool) $createDocuments;
	}

	/**
	 * Get the current state of teh create documents flag.
	 *
	 * @return boolean
	 */
	public function getCreateDocuments()
	{
		return $this->_createDocuments;
	}

	/**
	 * Set the collapse single value arrays flag.
	 *
	 * @param boolean $collapseSingleValueArrays
	 */
	public function setCollapseSingleValueArrays($collapseSingleValueArrays)
	{
		$this->_collapseSingleValueArrays = (bool) $collapseSingleValueArrays;
	}

	/**
	 * Get the current state of the collapse single value arrays flag.
	 *
	 * @return boolean
	 */
	public function getCollapseSingleValueArrays()
	{
		return $this->_collapseSingleValueArrays;
	}

	/**
	 * Set how NamedLists should be formatted in the response data. This mainly effects
	 * the facet counts format.
	 *
	 * @param string $namedListTreatment
	 * @throws Exception If invalid option is set
	 */
	public function setNamedListTreatmet($namedListTreatment)
	{
		switch ((string) $namedListTreatment)
		{
			case Apache_Solr_Service::NAMED_LIST_FLAT:
				$this->_namedListTreatment = Apache_Solr_Service::NAMED_LIST_FLAT;
				break;

			case Apache_Solr_Service::NAMED_LIST_MAP:
				$this->_namedListTreatment = Apache_Solr_Service::NAMED_LIST_MAP;
				break;

			default:
				throw new Exception('Not a valid named list treatement option');
		}
	}

	/**
	 * Get the current setting for named list treatment.
	 *
	 * @return string
	 */
	public function getNamedListTreatment()
	{
		return $this->_namedListTreatment;
	}


	/**
	 * Set the string used to separate the path form the query string.
	 * Defaulted to '?'
	 *
	 * @param string $queryDelimiter
	 */
	public function setQueryDelimiter($queryDelimiter)
	{
		$this->_queryDelimiter = $queryDelimiter;
	}

	/**
	 * Set the string used to separate the parameters in thequery string
	 * Defaulted to '&'
	 *
	 * @param string $queryStringDelimiter
	 */
	public function setQueryStringDelimiter($queryStringDelimiter)
	{
		$this->_queryStringDelimiter = $queryStringDelimiter;
	}

	/**
	 * Call the /admin/ping servlet, can be used to quickly tell if a connection to the
	 * server is able to be made.
	 *
	 * @param float $timeout maximum time to wait for ping in seconds, -1 for unlimited (default is 2)
	 * @return float Actual time taken to ping the server, FALSE if timeout occurs
	 */
	public function ping($timeout = 2)
	{
		$timeout = (float) $timeout;

		if ($timeout <= 0)
		{
			$timeout = -1;
		}

		$start = microtime(true);

		//to prevent strict errors
		$errno = 0;
		$errstr = '';

		//try to connect to the host with timeout
		$fp = fsockopen($this->_host, $this->_port, $errno, $errstr, $timeout);

		if ($fp)
		{
			//If we have a timeout set, then determine the amount of time we have left
			//in the request and set the stream timeout for the write operation
			if ($timeout > 0)
			{
				//do the calculation
				$writeTimeout = $timeout - (microtime(true) - $start);

				//check if we're out of time
				if ($writeTimeout <= 0)
				{
					fclose($fp);
					return false;
				}

				//convert to microseconds and set the stream timeout
				$writeTimeoutInMicroseconds = (int) $writeTimeout * 1000000;
				stream_set_timeout($fp, 0, $writeTimeoutInMicroseconds);
			}

			$request = 	'HEAD ' . $this->_path . self::PING_SERVLET . ' HTTP/1.1' . "\r\n" .
						'host: ' . $this->_host . "\r\n" .
						'Connection: close' . "\r\n" .
						"\r\n";

			fwrite($fp, $request);

			//check the stream meta data to see if we timed out during the operation
			$metaData = stream_get_meta_data($fp);

			if (isset($metaData['timeout']) && $metaData['timeout'])
			{
				fclose($fp);
				return false;
			}


			//if we have a timeout set and have made it this far, determine the amount of time
			//still remaining and set the timeout appropriately before the read operation
			if ($timeout > 0)
			{
				//do the calculation
				$readTimeout = $timeout - (microtime(true) - $start);

				//check if we've run out of time
				if ($readTimeout <= 0)
				{
					fclose($fp);
					return false;
				}

				//convert to microseconds and set the stream timeout
				$readTimeoutInMicroseconds = $readTimeout * 1000000;
				stream_set_timeout($fp, 0, $readTimeoutInMicroseconds);
			}

			//at the very least we should get a response header line of
			//HTTP/1.1 200 OK
			$response = fread($fp, 15);

			//check the stream meta data to see if we timed out during the operation
			$metaData = stream_get_meta_data($fp);
			fclose($fp); //we're done with the connection - ignore the rest

			if (isset($metaData['timeout']) && $metaData['timeout'])
			{
				return false;
			}

			//finally, check the response header line
			if ($response != 'HTTP/1.1 200 OK')
			{
				return false;
			}

			//we made it, return the approximate ping time
			return microtime(true) - $start;
		}

		//we weren't able to make a connection
		return false;
	}

	/**
	 * Call the /admin/threads servlet and retrieve information about all threads in the
	 * Solr servlet's thread group. Useful for diagnostics.
	 *
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function threads()
	{
		return $this->_sendRawGet($this->_threadsUrl);
	}

	/**
	 * Raw Add Method. Takes a raw post body and sends it to the update service.  Post body
	 * should be a complete and well formed "add" xml document.
	 *
	 * @param string $rawPost
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function add($rawPost)
	{
		return $this->_sendRawPost($this->_updateUrl, $rawPost);
	}

	/**
	 * Add a Solr Document to the index
	 *
	 * @param Apache_Solr_Document $document
	 * @param boolean $allowDups
	 * @param boolean $overwritePending
	 * @param boolean $overwriteCommitted
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function addDocument(Apache_Solr_Document $document, $allowDups = false, $overwritePending = true, $overwriteCommitted = true)
	{
		$dupValue = $allowDups ? 'true' : 'false';
		$pendingValue = $overwritePending ? 'true' : 'false';
		$committedValue = $overwriteCommitted ? 'true' : 'false';

		$rawPost = '<add allowDups="' . $dupValue . '" overwritePending="' . $pendingValue . '" overwriteCommitted="' . $committedValue . '">';
		$rawPost .= $this->_documentToXmlFragment($document);
		$rawPost .= '</add>';
		return $this->add($rawPost);
	}

	/**
	 * Add an array of Solr Documents to the index all at once
	 *
	 * @param array $documents Should be an array of Apache_Solr_Document instances
	 * @param boolean $allowDups
	 * @param boolean $overwritePending
	 * @param boolean $overwriteCommitted
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function addDocuments($documents, $allowDups = false, $overwritePending = true, $overwriteCommitted = true)
	{
		$dupValue = $allowDups ? 'true' : 'false';
		$pendingValue = $overwritePending ? 'true' : 'false';
		$committedValue = $overwriteCommitted ? 'true' : 'false';

		$rawPost = '<add allowDups="' . $dupValue . '" overwritePending="' . $pendingValue . '" overwriteCommitted="' . $committedValue . '">';

		foreach ($documents as $document)
		{
			if ($document instanceof Apache_Solr_Document)
			{
				$rawPost .= $this->_documentToXmlFragment($document);
			}
		}

		$rawPost .= '</add>';

		return $this->add($rawPost);
	}

	/**
	 * Create an XML fragment from a {@link Apache_Solr_Document} instance appropriate for use inside a Solr add call
	 *
	 * @return string
	 */
	protected function _documentToXmlFragment(Apache_Solr_Document $document)
	{
		$xml = '<doc';
		
		if ($document->getBoost() !== false)
		{
			$xml .= ' boost="' . $document->getBoost() . '"';
		}
		
		$xml .= '>';

		foreach ($document as $key => $value)
		{
			$key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
			$fieldBoost = $document->getFieldBoost($key);

			if (is_array($value))
			{
				foreach ($value as $multivalue)
				{
					$xml .= '<field name="' . $key . '"';
					
					if ($fieldBoost !== false)
					{
						$xml .= ' boost="' . $fieldBoost . '"';
						
						// only set the boost for the first field in the set
						$fieldBoost = false;
					}
					
					$multivalue = htmlspecialchars($multivalue, ENT_NOQUOTES, 'UTF-8');

					$xml .= '>' . $multivalue . '</field>';
				}
			}
			else
			{
				$xml .= '<field name="' . $key . '"';
				
				if ($fieldBoost !== false)
				{
					$xml .= ' boost="' . $fieldBoost . '"';
				}
				
				$value = htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8');

				$xml .= '>' . $value . '</field>';
			}
		}

		$xml .= '</doc>';

		return $xml;
	}

	/**
	 * Send a commit command.  Will be synchronous unless both wait parameters are set to false.
	 *
	 * @param boolean $optimize Defaults to true
	 * @param boolean $waitFlush Defaults to true
	 * @param boolean $waitSearcher Defaults to true
	 * @param float $timeout Maximum expected duration (in seconds) of the commit operation on the server (otherwise, will throw a communication exception). Defaults to 1 hour
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function commit($optimize = true, $waitFlush = true, $waitSearcher = true, $timeout = 3600)
	{
		$searcherValue = $waitSearcher ? 'true' : 'false';

		$rawPost = '<commit waitSearcher="' . $searcherValue . '" />';

		return $this->_sendRawPost($this->_updateUrl, $rawPost, $timeout);
	}

	/**
	 * Raw Delete Method. Takes a raw post body and sends it to the update service. Body should be
	 * a complete and well formed "delete" xml document
	 *
	 * @param string $rawPost Expected to be utf-8 encoded xml document
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function delete($rawPost)
	{
		return $this->_sendRawPost($this->_updateUrl, $rawPost);
	}

	/**
	 * Create a delete document based on document ID
	 *
	 * @param string $id Expected to be utf-8 encoded
	 * @param boolean $fromPending
	 * @param boolean $fromCommitted
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function deleteById($id, $fromPending = true, $fromCommitted = true)
	{
		$pendingValue = $fromPending ? 'true' : 'false';
		$committedValue = $fromCommitted ? 'true' : 'false';

		//escape special xml characters
		$id = htmlspecialchars($id, ENT_NOQUOTES, 'UTF-8');

		$rawPost = '<delete fromPending="' . $pendingValue . '" fromCommitted="' . $committedValue . '"><id>' . $id . '</id></delete>';

		return $this->delete($rawPost);
	}

	/**
	 * Create a delete document based on a query and submit it
	 *
	 * @param string $rawQuery Expected to be utf-8 encoded
	 * @param boolean $fromPending
	 * @param boolean $fromCommitted
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function deleteByQuery($rawQuery, $fromPending = true, $fromCommitted = true)
	{
		$pendingValue = $fromPending ? 'true' : 'false';
		$committedValue = $fromCommitted ? 'true' : 'false';

		// escape special xml characters
		$rawQuery = htmlspecialchars($rawQuery, ENT_NOQUOTES, 'UTF-8');

		$rawPost = '<delete fromPending="' . $pendingValue . '" fromCommitted="' . $committedValue . '"><query>' . $rawQuery . '</query></delete>';

		return $this->delete($rawPost);
	}

	/**
	 * Send an optimize command.  Will be synchronous unless both wait parameters are set
	 * to false.
	 *
	 * @param boolean $waitFlush
	 * @param boolean $waitSearcher
	 * @param float $timeout Maximum expected duration of the commit operation on the server (otherwise, will throw a communication exception)
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function optimize($waitFlush = true, $waitSearcher = true, $timeout = 3600)
	{
		$searcherValue = $waitSearcher ? 'true' : 'false';

		$rawPost = '<optimize waitSearcher="' . $searcherValue . '" />';

		return $this->_sendRawPost($this->_updateUrl, $rawPost, $timeout);
	}

	/**
	 * Simple Search interface
	 *
	 * @param string $query The raw query string
	 * @param int $offset The starting offset for result documents
	 * @param int $limit The maximum number of result documents to return
	 * @param array $params key / value pairs for other query parameters (see Solr documentation), use arrays for parameter keys used more than once (e.g. facet.field)
	 * @return Apache_Solr_Response
	 *
	 * @throws Exception If an error occurs during the service call
	 */
	public function search($query, $offset = 0, $limit = 10, $params = array())
	{
		if (!is_array($params))
		{
			$params = array();
		}

		// construct our full parameters
		// sending the version is important in case the format changes
		$params['version'] = self::SOLR_VERSION;

		// common parameters in this interface
		$params['wt'] = self::SOLR_WRITER;
		$params['json.nl'] = $this->_namedListTreatment;

		$params['q'] = $query;
		$params['start'] = $offset;
		$params['rows'] = $limit;

		// use http_build_query to encode our arguments because its faster
		// than urlencoding all the parts ourselves in a loop
		$queryString = http_build_query($params, null, $this->_queryStringDelimiter);

		// because http_build_query treats arrays differently than we want to, correct the query
		// string by changing foo[#]=bar (# being an actual number) parameter strings to just
		// multiple foo=bar strings. This regex should always work since '=' will be urlencoded
		// anywhere else the regex isn't expecting it
 		$queryString = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $queryString);
                // we forward select to 'dismax' and 'dismaxAlerts' query, if forced by the 'qt' param, in
                // order to have this work on Solr >4
                if (array_key_exists('qt', $params)) {
                  $qt = $params['qt'];
                  if (in_array($qt, array('dismax', 'dismaxAlerts'))){
                    return $this->_sendRawGet($this->_constructUrl($qt) . $this->_queryDelimiter . $queryString);
                  }
                }
                return $this->_sendRawGet($this->_searchUrl . $this->_queryDelimiter . $queryString);

	}
}
