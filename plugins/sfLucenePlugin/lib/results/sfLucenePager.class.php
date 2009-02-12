<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Adds a paging mechanism similar to sfPropelPager to the results.  This is
 * meant to be as similar to sfPager and sfPropelPager as possible.
 *
 * TODO: Find a more efficient way to do paging!  Right now, it has to return
 * the entire result set and do an array_slice() on it.
 *
 * @package    sfLucenePlugin
 * @subpackage Results
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfLucenePager
{
  protected $results = array();
  protected $search = null;
  protected $page = 1, $perPage = 5;

  public function __construct($results, $search = null)
  {
    if ($results instanceof sfLuceneResults)
    {
      $search = $results->getSearch();
      $results = $results->toArray();
    }

    if (!($search instanceof sfLucene))
    {
      throw new sfLuceneResultsException('Pager constructor expects to somehow receive the search instance');
    }

    if (!is_array($results))
    {
      throw new sfLuceneResultsException('Pager constructor expects the results to be an array, ' . gettype($results) . ' given');
    }

    $this->results = $results;
    $this->search = $search;
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

  public function getLinks($nb_links = 5)
  {
    $links = array();
    $tmp   = $this->getPage() - floor($nb_links / 2);
    $check = $this->getLastPage() - $nb_links + 1;
    $limit = ($check > 0) ? $check : 1;
    $begin = ($tmp > 0) ? (($tmp > $limit) ? $limit : $tmp) : 1;

    $i = $begin;
    while (($i < $begin + $nb_links) && ($i <= $this->getLastPage()))
    {
      $links[] = $i++;
    }

    return $links;
  }

  public function haveToPaginate()
  {
    return (($this->getPage() != 0) && ($this->getNbResults() > $this->getMaxPerPage()));
  }

  public function getMaxPerPage()
  {
    return $this->perPage;
  }

  public function setMaxPerPage($per)
  {
    $this->perPage = $per;
  }

  public function setPage($page)
  {
    $this->page = $page;
  }

  public function getPage()
  {
    return $this->page;
  }

  public function getResults()
  {
    $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
    $limit = $this->getMaxPerPage();

    if ($limit == 0)
    {
      $results = $this->results;
    }
    else
    {
      $results = array_slice($this->results, $offset, $limit);
    }

    return new sfLuceneResults($results, $this->getSearch());
  }

  public function getNbResults()
  {
    return count($this->results);
  }

  public function getFirstPage()
  {
    return 1;
  }

  public function getLastPage()
  {
    return ceil($this->getNbResults() / $this->getMaxPerPage());
  }

  public function getNextPage()
  {
    return min($this->getPage() + 1, $this->getLastPage());
  }

  public function getPreviousPage()
  {
    return max($this->getPage() - 1, $this->getFirstPage());
  }

  public function getFirstIndice()
  {
    if ($this->getPage() == 0)
    {
      return 1;
    }
    else
    {
      return ($this->getPage() - 1) * $this->getMaxPerPage() + 1;
    }
  }

  public function getLastIndice()
  {
    if ($this->getPage() == 0)
    {
      return $this->getNbResults();
    }
    else
    {
      if (($this->getPage() * $this->getMaxPerPage()) >= $this->getNbResults())
      {
        return $this->getNbResults();
      }
      else
      {
        return ($this->getPage() * $this->getMaxPerPage());
      }
    }
  }
}