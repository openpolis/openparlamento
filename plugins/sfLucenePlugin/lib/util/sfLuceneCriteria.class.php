<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Provides a clean way to search the index, mimicking Propel Criteria.
 *
 * Usage example: <code>
 * $c = sfLuceneCriteria::newInstance()->add('the cool dude')->addField('sfl_category', array('Forum', 'Blog'));
 * </code>
 *
 * This class is not meant to reinvent the entire Zend Lucene's API, but rather
 * provide a simpler way to search.  It is possible to combine queries built with
 * the Zend API too.
 *
 * @package    sfLucenePlugin
 * @subpackage Utilities
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */

class sfLuceneCriteria
{
  protected $query = null;

  protected $sorts = array();

  public function __construct(sfLucene $search)
  {
    sfLucene::setupLucene();

    $this->query = new Zend_Search_Lucene_Search_Query_Boolean();
    $this->search = $search;
  }

  /**
   * Simply provides a way to do one line method chaining
   */
  static public function newInstance(sfLucene $search)
  {
    return new self($search);
  }

  /**
   * Adds a subquery to the query itself.  It accepts either a string which will
   * be parsed or a Zend query.
   */
  public function add($query, $type = true)
  {
    $this->search->configure();

    if (is_string($query))
    {
      $query = Zend_Search_Lucene_Search_QueryParser::parse($query);
    }
    else if ($query instanceof self)
    {
      if ($query === $this)
      {
        throw new sfLuceneException('You cannot add an instance to itself');
      }

      $query = $query->getQuery();
    }

    if (!($query instanceof Zend_Search_Lucene_Search_Query))
    {
      throw new sfLuceneException('Invalid query given');
    }

    $this->query->addSubquery($query, $type);

    return $this;
  }

  /**
  * This does a sane find on the current index.  The query parser tends to throw a lot
  * of exceptions even in normal conditions, so we need to intercept them and then fall back
  * into a reduced state mode should the user have entered invalid syntax.
  */
  public function addSane($query, $type = true, $fatal = false)
  {
    try
    {
      return $this->add($query, $type);
    }
    catch (Zend_Search_Lucene_Search_QueryParserException $e)
    {
      if (!is_string($query))
      {
        if ($fatal)
        {
          throw $e;
        }
        else
        {
          return $this;
        }
      }

      try
      {
        $replacements = array('+', '-', '&', '|', '!', '(', ')', '{', '}', '[', ']', '^', '"', '~', '*', '?', ':', '\\', ' and ', ' or ', ' not ');

        $query = ' ' . $query . ' ';
        $query = str_replace($replacements, '', $query);
        $query = trim($query);

        return $this->add($query, $type);
      }
      catch (Zend_Search_Lucene_Search_QueryParserException $e)
      {
        if ($fatal)
        {
          throw $e;
        }
        else
        {
          return $this;
        }
      }
    }
  }

  /**
   * Adds a field to the search query.
   * @param mixed $values The values to search on
   * @param string $field The field to search under (null for all)
   * @param bool $matchAll If true, it will match all.  False will match none.  Null is neutral.
   * @param bool $type The type of subquery to add.
   */
  public function addField($values, $field = null, $matchAll = null, $type = true)
  {
    if (is_array($values))
    {
      $query = $this->getNewCriteria();

      foreach($values as $value)
      {
        $term = new Zend_Search_Lucene_Index_Term($value, $field);
        $qterm = new Zend_Search_Lucene_Search_Query_Term($term);

        $query->add($qterm, $matchAll);
      }
    }
    elseif (is_scalar($values))
    {
      $values = (string) $values;

      $term = new Zend_Search_Lucene_Index_Term($values, $field);
      $query = new Zend_Search_Lucene_Search_Query_Term($term);
    }
    else
    {
      throw new sfLuceneException('Unknown field value type');
    }

    return $this->add($query, $type);
  }

  /**
  * Adds a multiterm query.
  */
  public function addMultiTerm($values, $field = null, $matchType = null, $type = true)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    $query = new Zend_Search_Lucene_Search_Query_MultiTerm();

    foreach ($values as $value)
    {
      $query->addTerm(new Zend_Search_Lucene_Index_Term($value, $field), $matchType);
    }

    return $this->add($query, $type);
  }


  /**
  * Adds a wildcard field.
  *   ? is used as single character wildcard
  *   * is used as a multi character wildcard.
  */
  public function addWildcard($value, $field = null, $type = true)
  {
    $pattern = new Zend_Search_Lucene_Index_Term($value, $field);
    $query = new Zend_Search_Lucene_Search_Query_Wildcard($pattern);

    return $this->add($query, $type);
  }

  /**
  * Adds a phrase query
  */
  public function addPhrase($keywords, $field = null, $slop = 0, $type = true)
  {
    $query = new Zend_Search_Lucene_Search_Query_Phrase(array_values($keywords), array_keys($keywords), $field);
    $query->setSlop($slop);

    return $this->add($query, $type);
  }

  /**
   * Adds a range subquery
   */
  public function addRange($start = null, $stop = null, $field = null, $inclusive = true, $type = true)
  {
    if ($start)
    {
      $start = new Zend_Search_Lucene_Index_Term($start, $field);
    }
    else
    {
      $start = null;
    }

    if ($stop)
    {
      $stop = new Zend_Search_Lucene_Index_Term($stop, $field);
    }
    else
    {
      $stop = null;
    }

    if ($stop == null && $start == null)
    {
      throw new sfLuceneException('You must specify at least a start or stop in a range query.');
    }

    $query = new Zend_Search_Lucene_Search_Query_Range($start, $stop, $inclusive);

    return $this->add($query, $type);
  }

  public function addAscendingSortBy($field, $type = SORT_REGULAR)
  {
    return $this->addSortBy($field, SORT_ASC, $type);
  }

  public function addDescendingSortBy($field, $type = SORT_REGULAR)
  {
    return $this->addSortBy($field, SORT_DESC, $type);
  }

  public function addSortBy($field, $order = SORT_ASC, $type = SORT_REGULAR)
  {
    $this->sorts[] = array('field' => $field, 'order' => $order, 'type' => $type);

    return $this;
  }

  /**
   * Returns a Zend_Search_Lucene query that can be fed directly to Lucene
   */
  public function getQuery()
  {
    return $this->query;
  }

  public function getSorts()
  {
    return $this->sorts;
  }

  public function getNewCriteria()
  {
    return new self($this->search);
  }
}
