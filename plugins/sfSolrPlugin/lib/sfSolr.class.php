<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
* sfSolr bridges symfony and Solr together to 
* add a search engine to your application. 
* Please see the README file for more.
*
* This class represents a Solr index.  It is responsible for managing the index 
* and for all the communications with the Solr index. 
* This is a wrapper around the Apache_Solr_Service class in vendor/Apache.
*
* @author     Guglielmo Celata <g.celata@depp.it>
* @author     Carl Vondrick <carlv@carlsoft.net>
* @package    sfSolrPlugin
*/
class sfSolr
{
  
  // the Apache_Solr_Service instance
  protected $_solrInstance;

  // Holds the model declarations
  protected $models = array();
  
  /**
  * Protected constructor
  */
  protected function __construct()
  {
    $conn_params = $this->loadConnectionConfig();
    if (!$conn_params)
    {
      throw new sfSolrException(sprintf('Error while reading the configuration.'));
    }

    $host = $conn_params['host'];
    $port = $conn_params['port'];
    $path = $conn_params['path'];
    
    $this->_solrInstance = new Apache_Solr_Service($host, $port, $path);      

    if (!$this->loadModelsConfig())
    {
      throw new sfSolrException(sprintf('Error while loading the model.'));
    }

    if (sfConfig::get('sf_logging_enabled'))
    {
      sfLogger::getInstance()->info(sprintf("{sfSolr} constructed new instance of index; host: %s, port: %s, path: %s", $host, $port, $path));
    }
  }

  /**
  * Singleton.  Gets the instance
  */
  static public function getInstance()
  {
    static $instance;

    if (!isset($instance))
    {
      $instance = new self;
    }

    return $instance;
  }


  /**
   * returns the solr instance for straightforward operations, 
   * like fast removal of indexes
   *
   * @return void
   * @author Guglielmo Celata
   */
  public function getSolrInstance()
  {
    return $this->_solrInstance;
  }

 /**
  * Load the connection parameters from config/solr.yml and verify them
  * @return  hash - key/value for the connection parameters
  */
  protected function loadConnectionConfig()
  {
    # inclusione di files di config aggiuntivi
    include_once(sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_config_dir_name') . 
            DIRECTORY_SEPARATOR . 'solr.yml'));

    $host = sfConfig::get('solr_connection_host', 'localhost');
    $port = sfConfig::get('solr_connection_port', '8080');
    $path = sfConfig::get('solr_connection_path', '/solr');
    
    $conn_params = array('host' => $host,
                         'port' => $port,
                         'path' => $path);
    return $conn_params;    
  }


  /**
   * Load the models config from  from apps/APP/config/search.yml
   * @return  hash - route and partial are specified for each model
   */
  protected function loadModelsConfig()
  {
    include_once(sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_config_dir_name') . 
                                                      DIRECTORY_SEPARATOR . 'search.yml'));

    if (!isset($config['SolrIndex']))
    {
      return false;
    }

    $this->models = $config['SolrIndex']['models'];

    return true;
  }

  /**
    * Returns just one model
    * @param string $model The model to look up
    * @return mixed Null if not found, array of config options if found.
    */
  public function dumpModel($model)
  {
    if (isset($this->models[$model]))
    {
      return $this->models[$model];
    }
    else
    {
      return null;
    }
  }


  /**
   * returns a resultset for a given query
   *
	 * @param string $query   The raw query string
	 * @param int    $offset  The starting offset for result documents
	 * @param int    $limit   The maximum number of result documents to return
	 * @param array  $options key/value pairs for query parameters, use arrays for multivalued parameters
   * @return Apache_Solr_Response
   */ 
  public function search($query, $offset=0, $limit=10, $options = array())
  {
    try {
      $response = $this->_solrInstance->search($query, $offset, $limit, $options);
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->info("{sfSolr::search}: error: " . $e->getMessage());
      throw new sfSolrException($e->getMessage());
    }
    return $response;  
  }

  /**
  * Searches the index for the query and returns them with a symfony friendly interface.
  * @param mixed $query The query
  * @return sfSolrResults The symfony friendly results.
  */
  public function friendlySearch($query, $offset=0, $limit=10, $options = array())
  {
    sfLogger::getInstance()->info('{sfSolr::friendlySearch::query} ' . $query);    
    sfLogger::getInstance()->info('{sfSolr::friendlySearch::offset} ' . $offset);                                                  
    sfLogger::getInstance()->info('{sfSolr::friendlySearch::limit} ' . $limit);                                                                                                      
    
    $response = $this->search($query, $offset, $limit, $options);
    
    return new sfSolrResults($response, $this);
  }

  
  /**
   * remove a document from the index
   * the document is tranformed into an Apache_Solr_Document if needed
   * 
   * @return void
	 * @param Object $document 
   **/
  public function removeDocument( $doc )
  {
    try {
      if (!$doc instanceof Apache_Solr_Document) $doc = $this->intoDocument($doc);      
      $this->_solrInstance->deleteById($doc->id);
      sfContext::getInstance()->getLogger()->info("{sfSolr::removeDocument} removed ".$doc->id);              
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->info("{sfSolr::removeDocument}: error: " . $e->getMessage());
      throw new sfSolrException($e->getMessage());
    }
  }

  /**
   * complete reset of the Index and their meta-informations
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function resetIndex()
  {
    $this->removeAllDocuments();
    $this->commit();
    $this->optimize();    
  }

  /**
   * bulk removal of all the documents from the index
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function removeAllDocuments()
  {
    $this->_solrInstance->deleteByQuery('*:*'); 
  }
  
  /**
   * index optimization
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function optimize()
  {
    $this->_solrInstance->optimize();        
  }

  /**
   * modifications are commited to the index
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function commit()
  {
    $this->_solrInstance->commit();        
  }
  

  /**
   * update of a document of the index
   * updating a document is a composition of a removal and an adding
   * the document is tranformed into an Apache_Solr_Document if needed
   *
	 * @param Object $document 
   * @return void
   * @author Guglielmo Celata
   **/
  public function updateDocument($doc)
  {
    if (!$doc instanceof Apache_Solr_Document) $doc = $this->intoDocument($doc);
    
    $this->removeDocument($doc);
    $this->addDocument($doc);
  }

  /**
   * adding of a document to the index
   * the document is tranformed into an Apache_Solr_Document if needed
   *
	 * @param Object $document 
   * @return void
   * @author Guglielmo Celata
   **/
  public function addDocument( $doc )
  {
    try {
      if (!$doc instanceof Apache_Solr_Document) $doc = $this->intoDocument($doc);
      $this->_solrInstance->addDocument($doc);


      sfContext::getInstance()->getLogger()->info("{sfSolr::addDocument} added ".$doc->id);
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->info("{sfSolr::addDocument}: error: " . $e->getMessage());
      throw new sfSolrException($e->getMessage());
    }

  }

  /**
   * adding of a group of documents to the index
   *
   * @param docs_ar - array of Objects to add (see addDocument)
   * @return void
   * @author Guglielmo Celata
   **/
  public function addDocuments($docs_ar)
  {
    $this->_solrInstance->addDocuments($docs_ar);
  }
  
  
  /**
   * trasformation of an object into an Apache_Solr_Document
   *
   * @return Apache_Solr_Document
   * @param  Object $cont - the object to transform
   * @author Guglielmo Celata
   **/
  public function intoDocument( $cont )
  {
    return $cont->intoSolrDocument();
  }

  /**
  * Returns the size of the index, in bytes.
  */
  public function byteSize()
  {
    $size = 0;

    foreach ( new DirectoryIterator($this->getIndexLoc()) as $node)
    {
      $size += $node->getSize();
    }

    return $size;
  }

  /**
  * Returns the number of segments for the index.
  */
  public function segmentCount()
  {
    return count(glob($this->getIndexLoc() . DIRECTORY_SEPARATOR.'_*.fdt'));
  }
  
  
  /**
  * Shortcut to retrieve the index location
  */
  protected function getIndexLoc()
  {
    return sfConfig::get('solr_index_dir');
  }
  

}
