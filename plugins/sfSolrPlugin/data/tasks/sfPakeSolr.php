<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    sfSolrPlugin
 * @subpackage Tasks
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */

pake_desc('returns the number of documents for a model or for the whole index');
pake_task('solr-count-documents', 'project_exists');
function run_solr_count_documents($task, $args)
{
  if (count($args) < 1 || count($args) > 2)
  {
    throw new Exception('Usage: solr-count-documents $APP [$MODEL].');
  }

  $app    = $args[0];
  _load_solr_application_environment(array($app));
  
  if (count($args) == 2)
    $model  = $args[1];

  $start_time = microtime(true);

  $iMan = sfSolr::getInstance();

  echo 'There are ';

  $n_global_docs = $iMan->search('*:*')->response->numFound;
  if (isset($model))
  {
    $n_model_docs = $iMan->search("sfl_model:$model")->response->numFound;    
    echo pakeColor::colorize(sprintf('%d', $n_model_docs), array('fg' => 'cyan'));
    echo ' documents for ' . $model;
    echo "\n";
    echo 'and a total of ';
  }
  echo pakeColor::colorize(sprintf('%d', $n_global_docs), array('fg' => 'cyan'));
  echo ' documents in the index.';
  echo "\n";

  $total_time = microtime(true) - $start_time;
  
}

pake_desc('provides information about the status of the index');
pake_task('solr-status', 'project_exists');

function run_solr_status($task, $args)
{

  if (count($args) < 1)
  {
    throw new Exception('Usage: solr-status $APP.');
  }

  $app    = $args[0];
  _load_solr_application_environment(array($app));
  
  $start_time = microtime(true);

  $iMan = sfSolr::getInstance();

  echo "\n";

  echo pakeColor::colorize(sprintf('Status of the Solr index:'), array('fg' => 'red', 'bold' => true)) . "\n";

  $numdocs = $iMan->search('*:*')->response->numFound;
  echo sprintf("   %-32s %d\n", pakeColor::colorize('Document Count:', 'INFO'), $numdocs);

  $segments = $iMan->segmentCount();
  echo sprintf("   %-32s %s\n", pakeColor::colorize('Segment Count:', 'INFO'), $segments);

  $raw_size = $iMan->byteSize();
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

}


pake_desc('delete all the indexes');
pake_task('solr-delete-all', 'project_exists');
function run_solr_delete_all($task, $args)
{
  if (count($args) == 0)
  {
    throw new Exception('You must specify the application.');
  }

  $app    = $args[0];
  _load_solr_application_environment(array($app));

  $start_time = microtime(true);

  $iMan = sfSolr::getInstance();

  echo pakeColor::colorize(sprintf('Deleting all indexes now...'), 
                           array('fg' => 'red', 'bold' => true)) . "\n";

  $iMan->resetIndex();

  echo "\n";
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Index cleaned in ';
  echo pakeColor::colorize(sprintf('%f', $total_time), array('fg' => 'cyan'));
  echo ' seconds.';

  echo "\n";
  
}


/**
 * Delete the index for the given propel model
 * it is assumed that each document in the index has a 'model' field, 
 * that contains the model as a string
 *
 */
pake_desc('delete all the indexes for a given propel model');
pake_task('solr-delete-propel-model', 'project_exists');
function run_solr_delete_propel_model($task, $args)
{
  if (count($args) < 2)
  {
    throw new Exception('Usage: solr-delete-propel-model $APP $MODEL.');
  }

  $app    = $args[0];
  _load_solr_application_environment(array($app));

  $model  = $args[1];

  $start_time = microtime(true);

  $iMan = sfSolr::getInstance();

  echo pakeColor::colorize(sprintf('Processing model %s now...', $model), 
                           array('fg' => 'red', 'bold' => true)) . "\n";

  $iMan->getSolrInstance()->deleteByQuery("sfl_model:$model");
  $iMan->commit();
  $iMan->optimize();

  echo "\n";
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Index removed in ';
  echo pakeColor::colorize(sprintf('%f', $total_time), array('fg' => 'cyan'));
  echo ' seconds.';

  echo "\n";

  
}


/**
 * Updates the solr index for the given propel model
 * the model is passed as argument 
 *
 */
pake_desc('selectively update the search index for a single propel model');
pake_task('solr-update-propel-model', 'project_exists');
function run_solr_update_propel_model($task, $args)
{
  if (count($args) < 2)
  {
    throw new Exception('Usage: solr-update-propel-model $APP $MODEL [$N_BULK] .');
  }

  $app    = $args[0];
  _load_solr_application_environment(array($app));

  $model  = $args[1];

  if (count($args) == 3) 
  {
    $n_bulk = (int)$args[2];
    if (!is_int($n_bulk) || $n_bulk < 0)
      throw new Exception('The number of bulks must be a positive integer.');
  } else 
    $n_bulk = 1000;
  
  $start_time = microtime(true);

  $instance = sfSolr::getInstance();

  echo pakeColor::colorize(sprintf('Processing model %s now...', $model), 
                           array('fg' => 'red', 'bold' => true)) . "\n";

  solr_update_propel_model($instance, $model, $n_bulk);

  echo "\n";
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Index updated in ';
  echo pakeColor::colorize(sprintf('%f', $total_time), array('fg' => 'cyan'));
  echo ' seconds.';

  echo "\n";

}

function solr_update_propel_model($iMan, $model, $n_bulk)
{
  $start_time = microtime(true);

  pake_echo_action('solr', sprintf('Updating %s...', $model));

  $per = $n_bulk;
  $peer = $model.'Peer';
  
  // calculate total number of pages
  $c = new Criteria();
  $count = call_user_func(array($peer, 'doCount'), $c);
  $totalPages = ceil($count / $per);

  $current_count = 0;
  for ($page = 0; $page < $totalPages; $page++)
  {
    $c = new Criteria();
    $c->setOffset($page * $per);
    $c->setLimit($per);
    $rs = call_user_func(array($peer, 'doSelectRS'), $c);

    $documents_ar = array();
    while ($rs->next())
    {
      $instance = new $model;
      $instance->hydrate($rs);

      $documents_ar[] = $iMan->intoDocument($instance);
      $current_count ++;
      unset($instance); // free memory
    }
    pake_echo_action('solr', sprintf("%d documents indexed", $current_count));
    $iMan->addDocuments($documents_ar);

    unset($document_ar);
    unset($rs); // free memory
  }
  
  pake_echo_action('solr', 'Optimizing...');

  $iMan->optimize();

  pake_echo_action('solr', 'Committing...');

  $iMan->commit();

  $execution_time = microtime(true) - $start_time;

  echo pakeColor::colorize('Done!', 'INFO') . " ";

  echo 'Indexed ';
  echo pakeColor::colorize($current_count, array('fg' => 'cyan'));
  echo ' documents in ';
  echo pakeColor::colorize(sprintf('%f', $execution_time), array('fg' => 'cyan'));
  echo ' seconds.';
  echo "\n\n";

  $n_global_docs = $iMan->search('*:*')->response->numFound;
  $n_model_docs = $iMan->search("model:$model")->response->numFound;
  echo 'There are now ';
  echo pakeColor::colorize(sprintf('%d', $n_model_docs), array('fg' => 'cyan'));
  echo ' documents for ' . $model;
  echo "\n";
  echo 'and a total of ';
  echo pakeColor::colorize(sprintf('%d', $n_global_docs), array('fg' => 'cyan'));
  echo ' documents in the index.';
  echo "\n";
  
  
}


pake_desc('initialize configuration files');
pake_task('solr-init', 'project_exists');

function run_solr_init($task, $args)
{
  _standard_solr_load($args);

  $skeleton_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'skeleton';
  $proj_config = sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'solr.yml';
  $app_config = sfConfig::get('sf_app_config_dir') . DIRECTORY_SEPARATOR .'search.yml';

  if (file_exists($proj_config) && file_exists($app_config))
  {
    throw new sfException('Nothing to do.');
  }

  pake_copy($skeleton_dir.DIRECTORY_SEPARATOR.'project'.
            DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'solr.yml', $proj_config);
  pake_copy($skeleton_dir.DIRECTORY_SEPARATOR.'app'.
            DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'search.yml', $app_config);
}

pake_desc('initialize an sfSolr module that you can override');
pake_task('solr-init-module', 'project_exists');

function run_solr_init_module($task, $args)
{
  _standard_solr_load($args);

  $skeleton_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'skeleton';

  $module_dir = sfConfig::get('sf_app_module_dir');

  $finder = pakeFinder::type('any')->ignore_version_control();
  pake_mirror($finder, $skeleton_dir.DIRECTORY_SEPARATOR.'module', $module_dir);
}


function _standard_solr_load($args)
{
  if (!count($args))
  {
    throw new sfException('You must provide an app.');
  }

  _load_application_environment($args);
}


function _check_solr_app($app)
{
  if (!is_dir(sfConfig::get('sf_app_dir') . DIRECTORY_SEPARATOR . $app))
  {
    throw new sfException('The app "' . $app . '" does not exist.');
  }
}

function _load_solr_application_environment($args)
{
  static $loaded;

  if (!$loaded)
  {
    _check_solr_app($args[0]);

    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', $args[0]);
    define('SF_ENVIRONMENT', !empty($args[1]) ? $args[1] : 'search');
    define('SF_DEBUG', true);

    require_once( SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.
                  DIRECTORY_SEPARATOR.SF_APP.
                  DIRECTORY_SEPARATOR.'config'.
                  DIRECTORY_SEPARATOR.'config.php');

    sfContext::getInstance();

    sfConfig::set('pake', true);

    error_reporting(E_ALL);

    $loaded = true;
  }
}

