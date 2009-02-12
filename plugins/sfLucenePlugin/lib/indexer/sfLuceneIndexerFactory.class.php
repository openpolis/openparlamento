<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Factory for indexer.  It determines the appropriate indexer to use.
 * @package sfLucenePlugin
 * @subpackage Indexer
 * @author Carl Vondrick
 */

class sfLuceneIndexerFactory
{
  protected $search;

  public function __construct($search)
  {
    $this->search = $search;
  }

  static public function newInstance($search)
  {
    return new self($search);
  }

  public function getHandlers()
  {
    $factories = $this->search->getFactories();
    $retval = array();
    $model = 'sfLucene' . ucfirst(sfConfig::get('sf_orm', 'Propel')) . 'IndexerHandler';

    $factories['indexers'] = array_merge(array('model' => array($model), 'action' => array('sfLuceneActionIndexerHandler')), $factories['indexers']);

    foreach ($factories['indexers'] as $label => $indexer)
    {
      if (is_null($indexer))
      {
        unset($retval[$label]);
      }
      elseif (isset($indexer[0]))
      {
        $indexer = $indexer[0];

        $retval[$label] = new $indexer($this->search);
      }
    }

    return $retval;
  }

  public function getModel($instance)
  {
    $model = $this->search->dumpModel(get_class($instance));

    if (isset($model['indexer']) && $model['indexer'])
    {
      $indexer = $model['indexer'];
    }
    else
    {
      $factories = $this->search->getFactories();

      if (isset($factories['indexers']['model'][1]))
      {
        $indexer = $factories['indexers']['model'][1];
      }
      else
      {
        $orm      = ucfirst(sfConfig::get('sf_orm', 'Propel'));
        $indexer  = 'sfLucene' . $orm . 'Indexer';
      }
    }

    if (!class_exists($indexer, true))
    {
      throw new sfLuceneIndexerException('Cannot locate "' . $indexer . '"');
    }

    return new $indexer($this->search, $instance);
  }

  public function getAction($module, $action)
  {
    $factories = $this->search->getFactories();

    if (isset($factories['indexers']['action'][1]))
    {
      $indexer = $factories['indexers']['action'][1];
    }
    else
    {
      $indexer = 'sfLuceneActionIndexer';
    }

    return new $indexer($this->search, $module, $action);
  }
}