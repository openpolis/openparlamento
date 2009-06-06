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
 * @subpackage Task that remove all expired premium subscriptions
 *
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */


pake_desc("downgrade expired premium subscriptions");
pake_task('opp-downgrade-expired-premium', 'project_exists');

/**
* Fetch users with premium subscriptions and check if their subscription is expired
* in case it is, the user is downgraded to the simple subscription
*/
function run_opp_downgrade_expired_premium($task, $args)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', 'be');
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

  # fetch of all expired premium subscribers (op_accesso)
  $opaccesso_key = sfConfig::get('api_opaccesso_key', '--XXX(-:-)XXX--');
  $remote_guard_host = sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it' ); 
  if (sfConfig::get('sf_environment') == 'dev')
    $controller = 'be_dev.php';
  else
    $controller = 'index.php';
  $xml = simplexml_load_file("http://$remote_guard_host/$controller/getSubscribers/expired_premium/$opaccesso_key");

  # debug
  #echo $xml->asXML();
  
  if ($xml->error)
  {
    echo "http://$remote_guard_host/$controller/getSubscribers/expired_premium/$opaccesso_key\n";
    echo (string)$xml->error . "\n";
    exit;
  }
  
  $subscribers_node = $xml->subscribers;
  $number = $subscribers_node['number'];
  foreach ($subscribers_node->subscriber as $subscriber_node) {
    downgrade($subscriber_node['id'], (string)$subscriber_node);
  }
  
  $total_time = microtime(true) - $start_time;

  echo 'Processed ';
  echo pakeColor::colorize($number, array('fg' => 'cyan'));

  echo ' users in ';
  echo pakeColor::colorize(sprintf("%f", $total_time), array('fg' => 'cyan'));
  echo " seconds\n";
  
}


pake_desc("downgrade a single user (by ID)");
pake_task('opp-downgrade-premium', 'project_exists');

/**
* force a downgrade on a single user, by email
*/
function run_opp_downgrade_premium($task, $args)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', 'be');
    define('SF_ENVIRONMENT', 'task');
    define('SF_DEBUG', false);

    require_once (SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.
                  DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.
                  DIRECTORY_SEPARATOR.'config.php');


    sfContext::getInstance();
    sfConfig::set('pake', true);
    
    error_reporting(E_ALL);

    $loaded = true;
  }


  if (count($args) < 1 || count($args) > 1)
  {
    throw new Exception('Usage: opp-downgrade-premium $USER_ID.');
  }

  $user_id    = $args[0];
  $user = OppUserPeer::retrieveByPK($user_id);
  if (!$user instanceof OppUser)
    throw new Exception('User not known: ' . $user_id. '.');

  $start_time = microtime(true);

  downgrade($user_id, $user->getEmail());
  
  $total_time = microtime(true) - $start_time;

  echo 'Processed in ';
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
function downgrade($user_id, $user_email)
{
  $start_time = microtime(true);

  $success = true;

  echo pakeColor::colorize(sprintf('Processing user %s...', $user_email), 
                           array('fg' => 'red', 'bold' => true));

  # rimozione della credential 'premium'
  # set a NULL della data di scadenza
  # downgrade on op_accesso
  $opaccesso_key = sfConfig::get('api_opaccesso_key', '--XXX(-:-)XXX--');
  $remote_guard_host = sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it' ); 
  if (sfConfig::get('sf_environment') == 'dev')
    $controller = 'be_dev.php';
  else
    $controller = 'index.php';
  $xml = simplexml_load_file("http://$remote_guard_host/$controller/downgradePremium/$user_id/$opaccesso_key");

  echo "opaccessokey: $opaccesso_key\n";

  $success = false;
  if ($xml->ok)
  {
    try 
    {
      # rimozione di tutti i monitoraggi attivi
      # set a 5/0 del n. max di item e argomenti monitorabili
      $opp_user = OppUserPeer::retrieveByPK($user_id);
      $opp_user->removeAllMonitoredObjects();
      $opp_user->setNMaxMonitoredItems(5);
      $opp_user->setNMaxMonitoredTags(0);
      $opp_user->save();

      $success = true;      
    } catch (Exception $e) {
      $err = $e->getMessage();      
    }
  } else {
    if ($xml->error)
    {
      $err = (string)$xml->error;
    } else {
      $err = "Errore sconosciuto";
    }    
  }
  

  $execution_time = microtime(true) - $start_time;
  
  
  if ($success) echo " ok (";
  else echo " $err (";
  echo pakeColor::colorize(sprintf("%f", $execution_time), array('fg' => 'cyan'));
  echo ")\n";
}
