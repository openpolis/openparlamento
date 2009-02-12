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

abstract class sfLuceneModelIndexerHandler extends sfLuceneIndexerHandler
{
  public function rebuild()
  {
    $models = $this->getSearch()->dumpModels();

    foreach ($models as $model => $config)
    {
      $this->rebuildModel($model);
    }
  }
}