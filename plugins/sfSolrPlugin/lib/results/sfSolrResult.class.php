<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Standard Solr result.  This does all the mapping to follow the symfony coding standard.
 * @package    sfSolrPlugin
 * @subpackage Results
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfSolrResult
{
  protected $result;

  protected $search;
  
  protected $maxScore;

  /**
  * Singleton consturctor.
  */
  protected function __construct($result, $search)
  {
    $this->result = $result;
    $this->search = $search;
  }

  protected function getSearch()
  {
    return $this->search;
  }

  /**
  * To be implemented later
  */
  public function valid()
  {
    return true;
  }

  /**
  * Factory.  Gets an instance of the appropriate result based off type
  */
  static public function getInstance($result, $search, $maxScore)
  {
    switch ($result->sfl_type)
    {
      case 'action':
        $c = 'sfSolrActionResult';
        break;
      case 'model':
        $c = 'sfSolrModelResult';
        break;
      default:
        $c = __CLASS__;
    }
    
    $r = new $c($result, $search);
    $r->setMaxScore($maxScore);
    
    return $r;
  }

  
  public function getMaxScore()
  {
    return $this->maxScore;
  }
  
  public function setMaxScore($ms)
  {
    $this->maxScore = $ms;
  }

  /**
  * Adapts the ->getXXX() methods to solr.
  */
  public function __call($method, $args = array())
  {
    if (substr($method, 0, 3) == 'get')
    {
      return $this->result->__get($this->getProperty($method, 'get'));
    }
    elseif (substr($method, 0, 3) == 'has')
    {
      try
      {
        $this->result->__get($this->getProperty($method, 'has'));

        return true;
      }
      catch (Exception $e)
      {
        return false;
      }
    }

    $call = array($this->result, $method);

    if (is_callable($call))
    {
      return call_user_func_array($call, $args);
    }

    return sfMixer::callMixins();
  }

  /**
  * Maps a property from a ->getXXX() method to a solr property
  */
  protected function getProperty($method, $prefix)
  {
    $property = substr($method, strlen($prefix));
    $property = strtolower($property);

    if (substr($property, 0, 8) == 'internal')
    {
      $property = 'sfl_' . substr($property, 8);
    }

    return $property;
  }

  /**
  * Gets the score of this hit.
  */
  public function getScore()
  {
    $maxScore = $this->getMaxScore();
    $normalizedScore = (float)$this->result->score / (float)$maxScore;
    return ((int) ($normalizedScore * 100 + .5)); // round to nearest integer
  }

  /**
  * Gets the partial
  */
  public function getInternalPartial()
  {
    return 'sfSolr/' . $this->getInternalType() . 'Result';
  }

  public function getInternalDescription()
  {
    try
    {
      return strip_tags($this->sfl_description);
    }
    catch (Exception $e)
    {
      $responses = array('Click for more information', 'No description available', 'Open this item for more information');

      return $responses[array_rand($responses)];
    }
  }

  /**
  * Wrapper for solr's __get()
  */
  public function __get($property)
  {
    return $this->result->$property;
  }
}
