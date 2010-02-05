<?php
/*
 * This file is part of the deppOppTasks package.
 *
 * (c) 2009 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * @package    
 * @subpackage Task that fetch alerts results by subscribers and send them by emails
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */

pake_desc("fetch today's alerts for subscribers and send them via e-mail");
pake_task('opp-send-alerts', 'project_exists');

pake_desc("test alerts production");
pake_task('opp-test-alerts', 'project_exists');

/**
* Fetch alerts and send them via e-mail
*/
function run_opp_send_alerts($task, $args)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', 'fe');
    define('SF_ENVIRONMENT', 'task');
    define('SF_DEBUG', true);

    require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

    sfContext::getInstance();
    sfConfig::set('pake', true);
    
    error_reporting(E_ALL);

    $loaded = true;
  }


  $start_time = microtime(true);

  $c = new Criteria();
  $c->add(OppUserPeer::N_ALERTS, 0, Criteria::GREATER_THAN);
  $users = OppUserPeer::doSelect($c);

  foreach ($users as $user)
  {
    opp_send_single_alert($user);
  }
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'cyan', 'bold' => true));

  echo 'Processed ';
  echo pakeColor::colorize(count($users), array('fg' => 'cyan'));

  echo ' users in ';
  echo pakeColor::colorize(sprintf("%f", $total_time), array('fg' => 'cyan'));
  echo " seconds\n";

}

/**
 * send via email, today's alerts for a user
 *
 * @param string $user - OppUser object
 * @return void
 * @author Guglielmo Celata
 */
function opp_send_single_alert($user)
{
  $start_time = microtime(true);

  echo pakeColor::colorize(sprintf("Processo l'utente %s...\n", $user), 
                           array('fg' => 'red', 'bold' => true));


   // invoke the action that sends the email
   sfContext::getInstance()->getRequest()->setParameter('user_id', $user->getId());
   try {
     $raw_email = sfContext::getInstance()->getController()->sendEmail('monitoring', 'sendAlerts');
     // log the email
     sfContext::getInstance()->getLogger()->debug($raw_email);
   } catch (Exception $e) {
     echo pakeColor::colorize(sprintf(" err: %s - ", $e->getMessage()), array('fg' => 'red'));
   }

  $execution_time = microtime(true) - $start_time;
  if (isset($raw_email) && $raw_email != '') 
    echo pakeColor::colorize("ok (", array('fg' => 'cyan'));
  else 
    echo pakeColor::colorize("no mail (", array('fg' => 'cyan'));

  echo pakeColor::colorize(sprintf("%f", $execution_time), array('fg' => 'cyan'));
  echo ")\n";
}


/**
* Fetch news and show them, for each users
*/
function run_opp_test_alerts($task, $args)
{
  static $loaded;


  // load application context
  if (!$loaded)
  {
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', 'fe');
    define('SF_ENVIRONMENT', 'task');
    define('SF_DEBUG', true);

    require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

    sfContext::getInstance();
    sfConfig::set('pake', true);
    
    error_reporting(E_ALL);

    $loaded = true;
  }

  sfLoader::loadHelpers(array('Partial'));
  

  $start_time = microtime(true);
  echo pakeColor::colorize("Hi, there!\n", array('fg' => 'green', 'bold' => true));

  $c = new Criteria();
  $c->add(OppUserPeer::N_ALERTS, 0, Criteria::GREATER_THAN);
  $users = OppUserPeer::doSelect($c);

  foreach ($users as $user)
  {
    opp_test_single_user_alerts($user);
  }
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Processed ';
  echo pakeColor::colorize(count($users), array('fg' => 'cyan'));

  echo ' users in ';
  echo pakeColor::colorize(sprintf("%f", $total_time), array('fg' => 'cyan'));
  echo " seconds\n";

}

// funzione che mappa l'estrazione dei termini dagli user_alerts
function extractTerm($value='')
{
  return $value['term'];
}

/**
 * fetch today's alert regarding terms monitored by the user
 *
 * @param string $user - OppUser object
 * @return void
 * @author Guglielmo Celata
 */
function opp_test_single_user_alerts($user)
{
  $start_time = microtime(true);
  
  $df = new sfDateFormat('it_IT');

  echo pakeColor::colorize(sprintf("Processo l'utente %s ...", $user), 
                           array('fg' => 'red', 'bold' => true));

  $user_alerts = oppAlertingTools::getUserAlerts($user, sfConfig::get('app_alert_max_results', 50));
  $n_alerts = OppAlertUserPeer::countUserAlerts($user);
  $n_total_notifications = oppAlertingTools::countTotalAlertsNotifications($user_alerts);
  
  if (count($user_alerts) > 0) {
    $user_alerts_expanded = join(", ", array_map('extractTerm', array_slice($user_alerts, 0, 3))) . 
                            ($n_alerts > 3?',...':'') ;
    
    echo pakeColor::colorize(sprintf("%d %s per %s\n", 
                                     $n_total_notifications, $n_total_notifications==1?'avviso':'avvisi',
                                     $user_alerts_expanded), 
                             array('fg' => 'red', 'bold' => true));
    echo pakeTaskUserAlerts($user_alerts);
    
  } else {
    echo pakeColor::colorize(sprintf(" (nessun alert)\n"), 
                             array('fg' => 'red', 'bold' => true));
  }
  
  $execution_time = microtime(true) - $start_time;

}

/**
 * build the string representing the user alerts, using the pake test task format
 *
 * @return string
 * @author Guglielmo Celata
 */
function pakeTaskUserAlerts($user_alerts)  
{
  $string = "";
  foreach ($user_alerts as $user_alert) {
    $alert_term = $user_alert['term'];
    $alert_results = $user_alert['results'];
    $string .= pakeColor::colorize(sprintf("La parola %s è stata trovata %d volte:\n", 
                                          $alert_term, count($alert_results)),
                                   array('fg' => 'cyan', 'bold' => true));
    foreach ($alert_results as $i => $res) {
      $string .= get_partial($res->getInternalAlertPartial(), array('result' => $res, 'term' => $alert_term));
    }
  }
  return $string;
}





