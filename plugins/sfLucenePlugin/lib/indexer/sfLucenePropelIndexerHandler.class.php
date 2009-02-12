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

class sfLucenePropelIndexerHandler extends sfLuceneModelIndexerHandler
{
  public function rebuildModel($name)
  {
    $options = $this->getSearch()->dumpModel($name);

    $per = $options['rebuild_limit'];
    $peer = $options['peer'];

    // calculate total number of pages
    $count = call_user_func(array($peer, 'doCount'), new Criteria);

    $totalPages = ceil($count / $per);

    for ($page = 0; $page < $totalPages; $page++)
    {
      $c = new Criteria;
      $c->setOffset($page * $per);
      $c->setLimit($per);

      $rs = call_user_func(array($peer, 'doSelectRS'), $c);

      while ($rs->next())
      {
        $instance = new $name;
        $instance->hydrate($rs);

        $this->getFactory()->getModel($instance)->save();

        unset($instance); // free memory
      }

      unset($rs); // free memory
    }
  }
}