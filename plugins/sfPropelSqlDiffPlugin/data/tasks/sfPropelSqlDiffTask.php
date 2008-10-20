<?php

pake_desc('generate database patch');
pake_task('propel-build-sql-diff');

pake_desc('insert database patch');
pake_task('propel-insert-sql-diff');

pake_desc('rebuild model and upgrade database');
pake_task('propel-update-all',
        'app_exists',             // 0. Pre-requisites
        'propel-build-model',     // 1. Rebuild model
        'propel-insert-sql-diff', // 3. generate and insert SQL
        'clear-cache'             // 4. Clear cache
);

function run_propel_build_sql_diff($task, $args)
{

  if (!count($args)) {
    throw new Exception('You must provide the application.');
  }
  $app = $args[0];
  if (!is_dir(sfConfig::get('sf_app_dir').DIRECTORY_SEPARATOR.$app)) {
    throw new Exception(sprintf('The app "%s" does not exist.', $app));
  }

  run_propel_build_sql($task, $args);

  pake_echo_action('propel-sql-diff', "building database patch");

  define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../../../..'));
  define('SF_APP',         $app);
  define('SF_ENVIRONMENT', isset($args[1]) ? $args[1] : 'dev');
  define('SF_DEBUG',       1);
  require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

  $databaseManager = new sfDatabaseManager();
  $databaseManager->initialize();

  
  $i = new dbInfo();
  $i->loadFromDb();
  
  $i2 = new dbInfo();
  $i2->loadAllFilesInDir(sfConfig::get('sf_data_dir').'/sql');
  $diff = $i->getDiffWith($i2);
  
  $filename = sfConfig::get('sf_data_dir').'/sql/diff.sql';
  if($diff=='') pake_echo_comment("no difference found");
  pake_echo_action('propel-sql-diff', "writing file $filename");
  file_put_contents($filename, $diff);
}

function run_propel_insert_sql_diff($task, $args)
{
  run_propel_build_sql_diff($task, $args);
  
  $filename = sfConfig::get('sf_data_dir').'/sql/diff.sql';
  pake_echo_action('propel-sql-diff', "executing file $filename");
  $i = new dbInfo();
  $i->executeSql(file_get_contents($filename));
}

function run_propel_update_all($task, $args)
{
}
