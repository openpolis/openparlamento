<?php
    /**
     *  Copyright 2005 Zervaas Enterprises (www.zervaas.com.au)
     *
     *  Licensed under the Apache License, Version 2.0 (the "License");
     *  you may not use this file except in compliance with the License.
     *  You may obtain a copy of the License at
     *
     *      http://www.apache.org/licenses/LICENSE-2.0
     *
     *  Unless required by applicable law or agreed to in writing, software
     *  distributed under the License is distributed on an "AS IS" BASIS,
     *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     *  See the License for the specific language governing permissions and
     *  limitations under the License.
     */


    /**
     * GsgXml
     *
     * A PHP class for generating XML data for the Google Sitemaps service.
     * This includes options for compressing the output
     *
     * @author  Quentin Zervaas
     * @version 1.0
     */
    class GsgXml
    {
        /**
         * Version of the Google Sitemap this class is for
         */
        var $sitemapVersion = '0.84';


        /**
         * URL to the namespace for Google Sitemaps
         */
        var $namespace = 'http://www.google.com/schemas/sitemap/0.84';


        /**
         * An array to hold the URL data in prior to generating XML
         */
        var $urls = array();


        /**
         * Character encoding to use in output XML
         */
        var $xmlEncoding = 'UTF-8';


        /**
         * The different values allowed for change frequency, if specified
         */
        var $changeFreqs = array('always', 'hourly', 'daily', 'weekly',
                                 'monthly', 'yearly', 'never');


        /**
         * Maximum length a URL can be
         */
        var $maxUrlLen = 2048;


        /**
         * The range of values priority can be
         */
        var $priorityMin = 0.0;
        var $priorityMax = 1.0;
        var $priorityStep = 0.1;
        var $priorityFormat = '%01.1f';


        /**
         * Format strings for representing last modified timestamps, using
         * gmdate() to format the strings. PHP's timezone flag outputs
         * in the format '+0000' rather than '+00:00'
         */
        var $lastModDate = 'Y-m-d';
        var $lastModDateTime = 'Y-m-d\TH:i:s';


        var $compressFunc = 'gzencode';

        /**
         * Maximum number of URLs that can be specified
         */
        var $maxURLs = 50000;

		var $errorMsg = '';

        /**
         * GsgXml constructor
         *
         * The constructor optionally allows you to specify a base URL, which
         * serves two purposes: 1) allows you to add URLs with paths only, and
         * auto-prepend the base URL in front of it, and 2) ensures added URLs
         * that include domain information match this base URL, as all URLs
         * in a single sitemap must be on the same scheme (http/https) and
         * domain.
         *
         * @access  public
         * @param   string  $baseUrl    Optional. The base URL for added URLs.
         *                              It is intended for a value such as
         *                              http://www.example.com however including
         *                              extra path info will work also, but if
         *                              extra path is included all added URLs
         *                              must be within this directory.
         */
        function GsgXml($baseUrl = '')
        {
            $this->baseUrl = strtolower($baseUrl);
            $this->baseUrlLen = strlen($this->baseUrl); // cycle saver
        }


        /**
         * addUrl
         *
         * Adds a URL to the sitemap. All data is optional, except for the actual
         * URL. The URL can include the domain info, but if it doesn't then the
         * $pathOnly parameter should be set to true. The last modified timestamp
         * can be either a date and time, or a date only.
         *
         * @access  public
         * @param   string  $url        The URL to add. The URL should not be escaped.
         * @param   bool    $pathOnly   Set to true if the URL contains only a path,
         *                              or leave at false if it contains the domain
         * @param   int     $lastModTs  The Unix/Epoch timestamp since the doc was modified.
         *                              Set this to null to not include this parameter.
         * @param   bool    $lastModTsDateOnly  If $lastModTs is specified, then setting
         *                                      this to true means the timestamp date will
         *                                      only be output, not the time.
         * @param   string  $changeFreq The frequency this URL is changed. Must be a valid
         *                              value from class $changeFreqs, otherwise ignored.
         * @param   float   $priority   The priority of this URL relative to other URLs
         *                              in the sitemap. Must be between $priorityMin and
         *                              $priorityMax inclusive, and a multiple of $priorityStep
         * @return  bool    True if URL was added, false if not (e.g. if didn't match $baseUrl)
         */
        function addUrl($url, $pathOnly = false, $lastModTs = null, $lastModTsDateOnly = false,
                        $changeFreq = null, $priority = null)
        {
			$this->errorMsg = '';

            if (count($this->urls) >= $this->maxURLs) {
				$this->errorMsg = "Only ".$this->maxURLs . " urls are allowed within a Google Sitemaps file.";
                return false;
			}

            if ($pathOnly) {
                $url = $this->baseUrl . $url;
                $url = substr($url, 0, $this->baseUrlLen-1).preg_replace('|/+|', '/', substr($url, $this->baseUrlLen -1)); // replace double slashes with a single slash
            }
            else if ($this->baseUrlLen > 0) {
                // check if the added URL matches the baseUrl
                if ($this->baseUrl != strtolower(substr($url, 0, $this->baseUrlLen))) {
					$this->errorMsg = 'The following url does not match the base url ('.$this->baseUrl.'): ' . $url . '!';
                    return false;
                }
            }

            $data = array('url' => $url);

            if (($lastModTs != '') && !is_null($lastModTs) && is_numeric($lastModTs)) {
                $data['lastmod'] = (int) $lastModTs;
                $data['lastmod_dateonly'] = (bool) $lastModTsDateOnly;
            } elseif(is_string($lastModTs)) {
            	// ts could be a preformated string
            	if ($lastModTs != '') {
            		$data['lastmod'] = $lastModTs;
            		$data['lastmod_dateonly'] = false;
            	}
            }

            if (!is_null($changeFreq) && in_array($changeFreq, $this->changeFreqs)) {
                $data['changefreq'] = $changeFreq;
            }

            if (!is_null($priority) && $priority != '') {
                $priority = (float) $priority;

                // ensure it's between the valid range, else ignore it
                if ($priority >= $this->priorityMin && $priority <= $this->priorityMax) {
                    // ok it's valid, now normalize the value
                    $tmp = floor($priority / $this->priorityStep);
                    $tmp = $priority - $tmp * $this->priorityStep;
                    $priority -= $tmp;

                    $data['priority'] = $priority;
                }
            }

            $this->urls[] = $data;
        }


        /**
         * output
         *
         * Output the generated XML. The data can either be returned or output
         * directly. If it is not being returned (i.e. being output directly
         * then you can optionally output the HTTP headers for the data
         *
         * @access  public
         * @param   bool    $return         Optional. True to return the XML, false to
         *                                  output it directly. If this is true, then
         *                                  the $sendHeaders parameter is ignored
         * @param   bool    $compress       Optional. True to compress the data using gzip
         * @param   bool    $sendHeaders    Optional. True to send HTTP headers. This
         *                                  parameter is only used if $return is true
         * @return  mixed                   void is $return is false, XML string if $return
         *                                  true and $compress false, gzip binary data
         *                                  if $return true and $compress true
         */
        function output($return = true, $compress = false, $sendHeaders = false)
        {
            $xml = $this->generateXml();
            if ($compress)
                $compress = function_exists($this->compressFunc);

            if ($compress)
                $xml = $this->compress($xml);

            if ($return) {
                return $xml;
            }
            else {
                if ($sendHeaders) {
                    if ($compress)
                        $mime = 'application/x-gzip';
                    else
                        $mime = 'text/xml';

                    header('Content-type: ' . $mime);
                    header('Content-length: ' . strlen($xml));
                }
                echo $xml;
            }
        }


        /**
         * generateXml
         *
         * Builds the sitemap XML from all the added URLs
         *
         * @access  public
         * @return  string  The generated XML
         */
        function generateXml()
        {
            $ret = array();

            $ret[] = sprintf('<?xml version="1.0" encoding="%s"?>', $this->xmlEncoding);
            $ret[] = sprintf('<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">');
            $ret[] = sprintf('<!-- Last update of sitemap %s -->', date($this->lastModDateTime).substr(date("O"),0,3).":".substr(date("O"),3));

            foreach ($this->urls as $url) {
                $ret[] = '<url>';
                $ret[] = sprintf('<loc>%s</loc>', $this->xmlEscape($url['url']));
                if (isset($url['lastmod'])) {
                	if (is_numeric($url['lastmod'])) {
                    $ret[] = sprintf('<lastmod>%s</lastmod>',
                                     $url['lastmod_dateonly'] ?
                                     date($this->lastModDate, $url['lastmod']) :
                                     date($this->lastModDateTime, $url['lastmod']).
                                     	substr(date("O", $url['lastmod']),0,3) . ":" .
                                     	substr(date("O",$url['lastmod']),3));
                	} elseif (is_string($url['lastmod'])) {
                		$ret[] = sprintf('<lastmod>%s</lastmod>',$url['lastmod']);
                	}
               }
                if (isset($url['changefreq'])) {
                    $ret[] = sprintf('<changefreq>%s</changefreq>',
                                     $this->xmlEscape($url['changefreq']));
                }
                if (isset($url['priority'])) {
                    $priorityStr = sprintf('<priority>%s</priority>', $this->priorityFormat);
                    $ret[] = sprintf($priorityStr, $url['priority']);
                }
                $ret[] = '</url>';
            }

            $ret[] = '</urlset>';

            return join("\n", $ret);
        }


        /**
         * compress
         *
         * Compresses a text string with GZIP, and returns the compressed data
         *
         * @access  public
         * @param   string  The string to compress
         * @return          The compressed gzip data, or null if the compression callback is not found
         */
        function compress($string)
        {
            $func = $this->compressFunc;

            if (strlen($func) == 0 || !function_exists($func))
                return null;

            return $func($string);
        }


        /**
         * xmlEscape
         *
         * Escapes a string to be used as XML cdata. Borrowed from PHP
         * manual comments on htmlentities()
         *
         * @see     http://www.php.net/htmlentities
         *
         * @param   string  $str        The string to escape
         * @return  string              The escaped string
         */
        function xmlEscape($str)
        {
            static $trans;
            if (!isset($trans)) {
                $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                foreach ($trans as $key => $value)
                    $trans[$key] = '&#'.ord($key).';';
                // dont translate the '&' in case it is part of &xxx;
                $trans[chr(38)] = '&';
            }
            return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,4};)/","&#38;" , strtr($str, $trans));
        }
    }
?>