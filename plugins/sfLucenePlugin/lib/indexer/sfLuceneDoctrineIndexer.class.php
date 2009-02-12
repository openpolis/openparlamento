<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Doctrine indexing engine.
 *
 * @package sfLucenePlugin
 * @subpackage Indexer
 * @author Carl Vondrick
 * @todo Implementation
 */
class sfLuceneDoctrineIndexer extends sfLuceneModelIndexer
{
  public function __construct($a, $b)
  {
    throw new sfLuceneIndexerException('Doctrine is support is coming, but it\'s not here right now.');
  }

  public function insert()
  {
  }

  public function delete()
  {
  }

  public function shouldIndex()
  {
  }
}