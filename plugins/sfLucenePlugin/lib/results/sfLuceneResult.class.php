<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Standard Lucene result.  This does all the mapping to follow the symfony coding standard.
 * @package    sfLucenePlugin
 * @subpackage Results
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfLuceneResult
{
  protected $result;

  protected $search;

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
  static public function getInstance($result, $search)
  {
    switch ($result->sfl_type)
    {
      case 'action':
        $c = 'sfLuceneActionResult';
        break;
      case 'model':
        $c = 'sfLuceneModelResult';
        break;
      default:
        $c = __CLASS__;
    }

    return new $c($result, $search);
  }

  /**
  * Adapts the ->getXXX() methods to lucene.
  */
  public function __call($method, $args = array())
  {
    if (substr($method, 0, 3) == 'get')
    {
      return $this->result->getDocument()->getFieldValue($this->getProperty($method, 'get'));
    }
    elseif (substr($method, 0, 3) == 'has')
    {
      try
      {
        $this->result->getDocument()->getFieldValue($this->getProperty($method, 'has'));

        return true;
      }
      catch (Exception $e)
      {
        return false;
      }
    }

    $call = array($this->results, $method);

    if (is_callable($call))
    {
      return call_user_func_array($call, $args);
    }

    return sfMixer::callMixins();
  }

  /**
  * Maps a property from a ->getXXX() method to a lucene property
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
    return ((int) ($this->result->score * 100 + .5)); // round to nearest integer
  }

  /**
  * Gets the partial
  */
  public function getInternalPartial()
  {
    return 'sfLucene/' . $this->getInternalType() . 'Result';
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
  * Wrapper for lucene's __get()
  */
  public function __get($property)
  {
    return $this->result->$property;
  }
}
