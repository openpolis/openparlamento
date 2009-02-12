<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package sfLucenePlugin
 * @subpackage Indexer
 * @author Carl Vondrick
 */

abstract class sfLuceneIndexerHandler
{
  protected $search;

  public function __construct($search)
  {
    $this->search = $search;
  }

  protected function getSearch()
  {
    return $this->search;
  }

  protected function getFactory()
  {
    return new sfLuceneIndexerFactory($this->getSearch());
  }

  abstract public function rebuild();
}