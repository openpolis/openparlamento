<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

pake_desc('clear cached xmls');
pake_task('fb-clear-xml-cache', 'project_exists');
pake_alias('cx', 'fb-clear-xml-cache');


/**
 * clears xml files in the cache
 *
 * @example symfony fb-clear-xml-cache
 * @example symfony cx
 *
 * @param object $task
 * @param array $args
 */
function run_fb_clear_xml_cache($task, $args)
{
  if (!file_exists('cache'))
  {
    throw new Exception('Cache directory does not exist.');
  }

  $xml_cache_dir = sfConfig::get('sf_root_cache_dir')."/atti";


  // finder to remove all files in a cache directory
  $finder = pakeFinder::type('file')->ignore_version_control()->discard('.sf');
  foreach ($args as $id) {
    $finder = $finder->name($id.".xml");
  }

  // actually do remove the files under xml_cache_dir
  pake_remove($finder, $xml_cache_dir);

}
