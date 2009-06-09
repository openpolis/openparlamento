<?php
/**
 * This task is used to make a tarball of the project ommiting subversion, eclipse, cache and log files
 *
 * It will look for the XSLT file data/transform/clay2propel.xsl
 * 
 * @author  <anoy@arti-shock.com>
 * 
 * usage : 
 *   symfony tar
 * 
 * installation :
 *   Just drop it in SF_DATA_DIR/tasks/
 */


pake_desc( 'Clear memcache' );
pake_task( 'clear-memcache', 'app_exists' );

function run_clear_memcache( $task, $args ) 
{
  define('SF_ROOT_DIR',    realpath(dirname(__file__).'/../../../../'));
  define('SF_APP',         $args[0]);
  define('SF_ENVIRONMENT', 'dev');
  define('SF_DEBUG',       true);

  require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');


  // Clear all cache.
  $cache = new sfMemcacheCache ( sfConfig::get('sf_cache_dir'));
  $cache->clean();
  echo "Cleared\n";
}

?>

