<?php
/*
 * This file is part of the deppOppTasks package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * @package    
 * @subpackage Task that fetches politicians' images from op_openpolis and  
 *             stores resized versions in the op_openparlamento db
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("sync politicians' images from op_openpolis, storing resized versions in the local db");
pake_task('opp-sync-polimages', 'project_exists');

/**
* Fetch politicians' images from op_openpolis via remote getPolImage API call and store resized versions in the local db
*/
function run_opp_sync_polimages($task, $args)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', 'fe');
    define('SF_ENVIRONMENT', 'task');
    define('SF_DEBUG', true);

    require_once (SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.
                  DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.
                  DIRECTORY_SEPARATOR.'config.php');


    sfContext::getInstance();
    sfConfig::set('pake', true);
    
    error_reporting(E_ALL);

    $loaded = true;
  }


  $start_time = microtime(true);

  $c = new Criteria();
  $politicians = OppPoliticoPeer::doSelect($c);
  
  foreach ($politicians as $pol)
  {
    opp_sync_politician_image($pol);
  }
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Processed ';
  echo pakeColor::colorize(count($politicians), array('fg' => 'cyan'));

  echo ' users in ';
  echo pakeColor::colorize(sprintf("%f", $total_time), array('fg' => 'cyan'));
  echo " seconds\n";

}

/**
 * fetch today's news regarding objects monitored by the user
 *
 * @param string $user - OppUser object
 * @return void
 * @author Guglielmo Celata
 */
function opp_sync_politician_image($pol)
{
  $start_time = microtime(true);

  $success = true;

  echo pakeColor::colorize(sprintf('Processing politician %s...', $pol), 
                           array('fg' => 'red', 'bold' => true));


  // invoke the remote getPolImage function to grab the images from op_openpolis
  $remote_img_url = sfConfig::get('app_remote_politicians_images_service_url') .'/' . 
                    sfConfig::get('app_remote_openpolis_api_key') . '/' . 
                    $pol->getId();

  /* debug
  echo pakeColor::colorize(sprintf('Url:  %s...', $remote_img_url), 
                          array('fg' => 'red', 'bold' => true));
  */


  $file = fopen ($remote_img_url, "r");
  if (!$file) {
      $err =  "unable to open remote file.";
      $success = false;
  }
  $remote_img_str = '';
  while (!feof ($file)) {
    $remote_img_str .= fgets ($file, 1024);
  }
  fclose($file);

  $images_root = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.
                             DIRECTORY_SEPARATOR.'images'.
                             DIRECTORY_SEPARATOR.'parlamentari'.DIRECTORY_SEPARATOR;

  
  // resizes images and stores them in the FS
  
  $picture = new sfImage();
  $picture->setMimeType('image/jpeg');
  $picture->loadString($remote_img_str);
  $picture->resize(91, null);
  $picture->saveAs($images_root . 'picture/' . $pol->getId() . '.jpeg', 'image/jpeg');
  
  $thumb = new sfImage();
  $thumb->setMimeType('image/jpeg');
  $thumb->loadString($remote_img_str);
  $thumb->resize(40, null);
  $thumb->saveAs($images_root . 'thumb/' . $pol->getId() . '.jpeg', 'image/jpeg');
  
  $execution_time = microtime(true) - $start_time;
  
  
  if ($success) echo " ok (";
  else echo " $err (";
  echo pakeColor::colorize(sprintf("%f", $execution_time), array('fg' => 'cyan'));
  echo ")\n";
}
