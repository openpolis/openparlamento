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

class sfLuceneActionIndexerHandler extends sfLuceneIndexerHandler
{
  public function rebuild()
  {
    $prefix = sfConfig::get('sf_app_dir') . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
    $suffix = DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'search.yml';

    $path = $prefix . '*' . $suffix;

    $searches = glob($path);

    foreach ($searches as $search)
    {
      $module = substr($search, strlen($prefix), strlen($search) - strlen($prefix) - strlen($suffix));

      $this->rebuildModule($module);
    }
  }

  public function rebuildModule($module)
  {
   $config = sfConfig::get('sf_app_dir') . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR  . $module . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'search.yml';

    if (!is_readable($config))
    {
      throw new sfLuceneIndexerException(sprintf('Unable to read "%s"', $config));
    }

    include(sfConfigCache::getInstance()->checkConfig($config));

    if (!isset($actions) || !is_array($actions))
    {
      throw new sfLuceneIndexerException(sprintf('No actions were defined for module "%s", but a search.yml file was found', $module));
    }
    elseif (count($actions) == 0)
    {
      return;
    }

    if (isset($actions[$this->getSearch()->getName()]))
    {
      foreach ($actions[$this->getSearch()->getName()] as $action => $properties)
      {
        $this->getFactory()->getAction($module, $action)->save();
      }
    }
  }
}