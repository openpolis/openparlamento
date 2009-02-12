<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    sfLucenePlugin
 * @subpackage Tasks
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */

pake_desc('rebuilds the search index');
pake_task('lucene-rebuild', 'project_exists');

/**
* Rebuilds the entire search index.
*/
function run_lucene_rebuild($task, $args)
{
  _standard_load($args);

  $start_time = microtime(true);

  $instances = sfLucene::getAllInstances(true);

  foreach ($instances as $instance)
  {
    echo pakeColor::colorize(sprintf('Processing "%s/%s" now...', $instance->getName(), $instance->getCulture()), array('fg' => 'red', 'bold' => true)) . "\n";

    lucene_rebuild_search($instance);

    echo "\n";
  }

  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Rebuilt for ';
  echo pakeColor::colorize(count($instances), array('fg' => 'cyan'));

  if (count($instances) == 1)
  {
    echo ' index in ';
  }
  else
  {
    echo ' indexes in ';
  }

  echo pakeColor::colorize(sprintf('%f', $total_time), array('fg' => 'cyan'));
  echo ' seconds.';

  echo "\n";

}

function lucene_rebuild_search($search)
{
  $start_time = microtime(true);

  pake_echo_action('lucene', 'Created new index');
  pake_echo_action('lucene', 'Rebuilding...');

  $search->rebuildIndex();

  pake_echo_action('lucene', 'Optimizing...');

  $search->optimize();

  pake_echo_action('lucene', 'Committing...');

  $search->commit();

  $execution_time = microtime(true) - $start_time;

  echo pakeColor::colorize('Done!', 'INFO') . " ";

  echo 'Indexed ';
  echo pakeColor::colorize($search->numDocs(), array('fg' => 'cyan'));
  echo ' documents in ';

  echo pakeColor::colorize(sprintf('%f', $execution_time), array('fg' => 'cyan'));

  echo ' seconds.';

  echo "\n";
}

pake_desc('optimizes the search index');
pake_task('lucene-optimize', 'project_exists');

/**
* Optimizes the search index
*/
function run_lucene_optimize($task, $args)
{
  _standard_load($args);

  $start_time = microtime(true);

  $instances = sfLucene::getAllInstances();

  foreach ($instances as $instance)
  {
    echo pakeColor::colorize(sprintf('Optimizing "%s/%s" now...', $instance->getName(), $instance->getCulture()), array('fg' => 'red', 'bold' => true)) . "\n";

    lucene_optimize_search($instance);

    echo "\n";
  }

  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Optimized for ';
  echo pakeColor::colorize(count($instances), array('fg' => 'cyan'));

  if (count($instances) == 1)
  {
    echo ' index in ';
  }
  else
  {
    echo ' indexes in ';
  }

  echo pakeColor::colorize(sprintf('%f', $total_time), array('fg' => 'cyan'));
  echo ' seconds.';

  echo "\n";

}

/**
* Optimizes the search index
*/
function lucene_optimize_search($search)
{
  pake_echo_action('lucene', 'Optimizing...');

  $start_time = microtime(true);

  $search->optimize();

  $execution_time = microtime(true) - $start_time;

  echo pakeColor::colorize('Done!', 'INFO') . " ";

  echo 'Optimized ';
  echo pakeColor::colorize($search->numDocs(), array('fg' => 'cyan'));
  echo ' documents in ';

  echo pakeColor::colorize(sprintf('%f', $execution_time), array('fg' => 'cyan'));

  echo ' seconds.';

  echo "\n";
}

pake_desc('provides information about this plugin');
pake_task('lucene-about', 'project_exists');

function run_lucene_about($task, $args)
{
  $version = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'VERSION');

  echo sprintf("%-35s %s", pakeColor::colorize('Plugin Version:', 'INFO'), $version);

  $version = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'Zend'.DIRECTORY_SEPARATOR.'VERSION.txt');

  echo sprintf("%-35s %s", pakeColor::colorize('Lucene Version:', 'INFO'), $version);

  if (count($args))
  {
    _load_application_environment($args);

    foreach (sfLucene::getAllInstances() as $search)
    {
      echo "\n";

      echo pakeColor::colorize(sprintf('For %s/%s:', $search->getName(), $search->getCulture()), array('fg' => 'red', 'bold' => true)) . "\n";

      $numdocs = $search->numDocs();

      echo sprintf("   %-32s %d\n", pakeColor::colorize('Document Count:', 'INFO'), $numdocs);

      $segments = $search->segmentCount();

      echo sprintf("   %-32s %s\n", pakeColor::colorize('Segment Count:', 'INFO'), $segments);

      $raw_size = $search->byteSize();

      if ($raw_size / 1024 > 1024)
      {
        $size = number_format($raw_size / pow(1024, 2), 3) . ' MB';
      }
      else
      {
        $size = number_format($raw_size / 1024, 3) . ' KB';
      }

      echo sprintf("   %-32s %s\n", pakeColor::colorize('Index Size:', 'INFO'), $size);

      $avg_doc = $numdocs > 0 ? ($raw_size / 1024) / $numdocs : 0;

      echo sprintf("   %-32s %f KB/doc\n", pakeColor::colorize('Avg Doc Size:', 'INFO'), $avg_doc);

      echo sprintf("   %-32s ", pakeColor::colorize('Index Condition:', 'INFO'));

      if ($segments == 0)
      {
        echo 'Empty: Perhaps you should rebuild the index?';
      }
      elseif ($segments == 1)
      {
        echo 'Great: No optimization neccessary';
      }
      elseif ($segments <= 10)
      {
        echo 'Good: Consider optimizing for full performance';
      }
      elseif ($segments <= 20)
      {
        echo pakeColor::colorize('Bad:', array('fg' => 'red', 'bold' => true));
        echo ' You should optimize the index';
      }
      else
      {
        echo pakeColor::colorize('Terrible:', array('fg' => 'red', 'bold' => true));
        echo ' Immediate optimization neccessary!';
      }

      echo "\n";

      $categories = implode(', ', sfLuceneCategory::getAllCategories($search));

      if (!empty($categories))
      {
        echo sprintf("   %-32s %s\n", pakeColor::colorize('Categories:', 'INFO'), $categories);
      }
    }
  }
  else
  {
    echo "\n";
    echo pakeColor::colorize('Tip:', array('fg' => 'cyan', 'bold' => true)) . ' Provide an application to get more information.' . "\n";
  }
}

pake_desc('initialize search configuration files');
pake_task('lucene-init', 'project_exists');

function run_lucene_init($task, $args)
{
  _standard_load($args);

  $skeleton_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'skeleton';
  $proj_config = sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'search.yml';
  $app_config = sfConfig::get('sf_app_config_dir') . DIRECTORY_SEPARATOR .'search.yml';

  if (file_exists($proj_config) && file_exists($app_config))
  {
    throw new sfException('Nothing to do.');
  }

  pake_copy($skeleton_dir.DIRECTORY_SEPARATOR.'project'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'search.yml', $proj_config);
  pake_copy($skeleton_dir.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'search.yml', $app_config);
}

pake_desc('initialize a sfLucene module that you can overload');
pake_task('lucene-init-module', 'project_exists');

function run_lucene_init_module($task, $args)
{
  _standard_load($args);

  $skeleton_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'skeleton';

  $module_dir = sfConfig::get('sf_app_module_dir');

  $finder = pakeFinder::type('any')->ignore_version_control();
  pake_mirror($finder, $skeleton_dir.DIRECTORY_SEPARATOR.'module', $module_dir);
}

function _standard_load($args)
{
  if (!count($args))
  {
    throw new sfException('You must provide an app.');
  }

  _load_application_environment($args);
}

function _check_app($app)
{
  if (!is_dir(sfConfig::get('sf_app_dir') . DIRECTORY_SEPARATOR . $app))
  {
    throw new sfException('The app "' . $app . '" does not exist.');
  }
}

function _load_application_environment($args)
{
  static $loaded;

  if (!$loaded)
  {
    _check_app($args[0]);

    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', $args[0]);
    define('SF_ENVIRONMENT', !empty($args[1]) ? $args[1] : 'search');
    define('SF_DEBUG', true);

    require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

    sfContext::getInstance();

    sfConfig::set('pake', true);

    error_reporting(E_ALL);

    $loaded = true;
  }
}