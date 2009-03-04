<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Symfony friendly wrapper for all the Solr hits and other generic variables (status, qTime, numFound, maxScore)
 *
 * This implemenets the appropriate interfaces so you can still access it as an array
 * and loop through it.
 *
 * @package    sfSolrPlugin
 * @subpackage Results
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfSolrResults implements Iterator, Countable, ArrayAccess
{
  protected $results = array();

  protected $status;
  protected $qTime;
  protected $numFound;
  protected $maxScore;
  protected $start;
  protected $rows;
  protected $pointer = 0;

  protected $search;

  /**
  * Constructor.
  */
  public function __construct($response, $search)
  {
    $this->status = $response->responseHeader->status;
    $this->qTime = $response->responseHeader->QTime;
    $this->numFound = $response->response->numFound;
    $this->maxScore = $response->response->maxScore;                                                            
    if ($this->numFound > 0)
    {
      $this->start = $response->response->start + 1;
      $this->rows = $response->responseHeader->params->rows;
      $this->results = $response->response->docs;
    }
    
    $this->search = $search;
  }

  /**
  * Gets a result instance for the result.
  */
  protected function getInstance($result)
  {
    return sfSolrResult::getInstance($result, $this->search, $this->getMaxScore());
  }

  /**
   * Hook for sfMixer
   */
  public function __call($a, $b)
  {
    return sfMixer::callMixins();
  }

  public function getSearch()
  {
    return $this->search;
  }

  public function current()
  {
    return $this->getInstance($this->results[$this->pointer]);
  }

  public function key()
  {
    return $this->pointer;
  }

  public function next()
  {
    $this->pointer++;
  }

  public function rewind()
  {
    $this->pointer = 0;
  }

  public function valid()
  {
    return isset($this->results[$this->pointer]);
  }

  public function count()
  {
    return count($this->results);
  }

  public function offsetExists($offset)
  {
    return isset($this->results[$offset]);
  }

  public function offsetGet($offset)
  {
    return $this->results[$offset];
  }

  public function offsetSet($offset, $set)
  {
    $this->results[$offset] = $set;
  }

  public function offsetUnset($offset)
  {
    unset($this->results[$offset]);
  }

  public function toArray()
  {
    return $this->results;
  }
  
  public function slice($offset, $limit)
  {
    $this->results =  array_slice($this->results, $offset, $limit);
  }
  
  public function getStatus()
  {
    return $this->status;
  }

  public function getQTime()
  {
    return $this->qTime;
  }
  
  public function getNumFound()
  {
    return $this->numFound;
  }
  
  public function getMaxScore()
  {
    return $this->maxScore;
  }
  
  public function getStart()
  {
    return $this->start;
  }
  
  public function getRows()
  {
    return $this->rows;
  }
  
}
