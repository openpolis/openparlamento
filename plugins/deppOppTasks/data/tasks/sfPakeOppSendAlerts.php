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
function run_opp_send_alerts($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', 'fe');
    define('SF_ENVIRONMENT', 'task');
    define('SF_DEBUG', false);

    require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

    sfContext::getInstance();
    sfConfig::set('pake', true);
    
    error_reporting(E_ALL);

    $loaded = true;
  }

  $last_alert = null;
  if (array_key_exists('last-alert', $options))
    $last_alert = strftime("%Y-%m-%dT%H:%M:%SZ", strtotime($options['last-alert']));

  // create a solr instance to read solr.yml config
  $solr_instance = deppOppSolr::getInstance();
  
  $start_time = microtime(true);

  $c = new Criteria();
  $c->add(OppUserPeer::WANTS_OPP_ALERTS, 1);
  $c->add(OppUserPeer::IS_ACTIVE, 1);
  $c->add(OppUserPeer::N_ALERTS, 0, Criteria::GREATER_THAN);
  if (count($args)) {
    $c->add(OppUserPeer::ID, $args, Criteria::IN);
  }
  $users = OppUserPeer::doSelect($c);

  $n_users = count($users);
  foreach ($users as $cnt => $user)
  {
    $last_alert = $user->getLastAlertedAt("%Y-%m-%dT%H:%M:%SZ");

    echo "$cnt/$n_users ";
    opp_send_single_user_alerts($user, $last_alert);
    
  }
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'green', 'bold' => true));

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
function opp_send_single_user_alerts($user, $last_alert)
{
  $start_time = microtime(true);

  echo pakeColor::colorize(sprintf("Processo l'utente %s...\n", $user), 
                           array('bold' => true));
  echo pakeColor::colorize(sprintf("Ultimo alert: %s\n", $last_alert));


   $user_alerts = oppAlertingTools::getUserAlerts($user, sfConfig::get('app_alert_max_results', 50), $last_alert);
   $n_alerts = OppAlertUserPeer::countUserAlerts($user);
   $n_total_notifications = oppAlertingTools::countTotalAlertsNotifications($user_alerts);

   if ($n_total_notifications > 0) {
     $user_alerts_expanded = join(", ", array_map('extractTerm', array_slice($user_alerts, 0, 5))) . 
                             ($n_alerts > 5?',...':'') ;

     echo pakeColor::colorize(sprintf("%d %s per %s (%s) ", 
                                      $n_total_notifications, $n_total_notifications==1?'avviso':'avvisi',
                                      $n_alerts==1?'un termine':$n_alerts.' termini',
                                      $user_alerts_expanded));

     // invoke the action that sends the email
     // all othe parameters used in the building of the email are re-calculated
     sfContext::getInstance()->getRequest()->setParameter('user_id', $user->getId());
     sfContext::getInstance()->getRequest()->setParameter('last_alert', $last_alert);
     try {
       $raw_email = sfContext::getInstance()->getController()->sendEmail('monitoring', 'sendAlerts');
       // log the email
       sfContext::getInstance()->getLogger()->debug($raw_email);
 
       // set the last_alerted_at field to now in the opp_user table
       $user->setLastAlertedAt(date('Y-m-d H:i'));
       $user->save();
     } catch (Exception $e) {
       echo pakeColor::colorize(sprintf(" err: %s - ", $e->getMessage()), array('fg' => 'red', 'bold' => true));
     }
     
   } else {
     echo pakeColor::colorize(sprintf(" (nessun avviso) "));
   }


  $execution_time = microtime(true) - $start_time;
  if (isset($raw_email) && $raw_email != '') 
    echo pakeColor::colorize("ok ", array('fg' => 'green', 'bold' => true));
  else 
    echo pakeColor::colorize("no mail ", array('fg' => 'cyan'));

  echo pakeColor::colorize(sprintf("(%5.3f s)\n\n", $execution_time), array('fg' => 'cyan'));
}


/**
* Fetch news and show them, for each users
*/
function run_opp_test_alerts($task, $args, $options)
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

  $last_alert = null;
  if (array_key_exists('last-alert', $options))
    $last_alert = strftime("%Y-%m-%dT%H:%M:%SZ", strtotime($options['last-alert']));

  // create a solr instance to read solr.yml config
  $solr_instance = deppOppSolr::getInstance();

  sfLoader::loadHelpers(array('Partial', 'sfSolr', 'DeppNews'));

  $start_time = microtime(true);
  echo pakeColor::colorize("Hi, there!\n", array('fg' => 'green', 'bold' => true));

  $c = new Criteria();
  $c->add(OppUserPeer::WANTS_OPP_ALERTS, 1);
  $c->add(OppUserPeer::IS_ACTIVE, 1);
  $c->add(OppUserPeer::N_ALERTS, 0, Criteria::GREATER_THAN);
  if (count($args)) {
    $c->add(OppUserPeer::ID, $args, Criteria::IN);
  }
  $users = OppUserPeer::doSelect($c);

  $n_users = count($users);
  echo pakeColor::colorize("$n_users users set alerts. Here are the notifications we would send them.\n", array('fg' => 'green'));
  foreach ($users as $cnt => $user)
  {
    $last_alert = $user->getLastAlertedAt("%Y-%m-%dT%H:%M:%SZ");

    echo "$cnt/$n_users ";
    opp_test_single_user_alerts($user, $last_alert);
  }
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'green', 'bold' => true));

  echo 'Processed ';
  echo pakeColor::colorize(count($users), array('fg' => 'cyan'));

  echo ' users in ';
  echo pakeColor::colorize(sprintf("%f", $total_time), array('fg' => 'cyan'));
  echo " seconds\n";

}

// funzione che mappa l'estrazione dei termini dagli user_alerts
function extractTerm($value='')
{
  $s = $value['term'];
  if (array_key_exists('type_filters', $value)) {
    $s .= ": " . OppAlertTermPeer::get_filters_labels($value['type_filters']);
  }
  return $s;
}

/**
 * fetch today's alert regarding terms monitored by the user
 *
 * @param string $user - OppUser object
 * @return void
 * @author Guglielmo Celata
 */
function opp_test_single_user_alerts($user, $last_alert)
{
  $start_time = microtime(true);
  
  $df = new sfDateFormat('it_IT');

  echo pakeColor::colorize(sprintf("Processo l'utente %s (%s)...\n", $user, $user->getToken()), 
                           array('bold' => true));
  echo pakeColor::colorize(sprintf("Ultimo alert: %s\n", $last_alert));

  $user_alerts = oppAlertingTools::getUserAlerts($user, sfConfig::get('app_alert_max_results', 50), $last_alert);
  $n_alerts = OppAlertUserPeer::countUserAlerts($user);
  $n_total_notifications = oppAlertingTools::countTotalAlertsNotifications($user_alerts);
  
  if ($n_total_notifications > 0) {
    $user_alerts_expanded = join(", ", array_map('extractTerm', array_slice($user_alerts, 0, 5))) . 
                            ($n_alerts > 5?',...':'') ;
    
    echo pakeColor::colorize(sprintf("%d %s per %s (%s)\n\n", 
                                     $n_total_notifications, $n_total_notifications==1?'avviso':'avvisi',
                                     $n_alerts==1?'un termine':$n_alerts.' termini',
                                     $user_alerts_expanded));

    echo pakeTaskUserAlerts($user_alerts);
    
  } else {
    echo pakeColor::colorize(sprintf(" (nessun avviso)\n\n"));
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
    if (array_key_exists('type_filters', $user_alert) && $user_alert['type_filters'] != '')
    {
      $alert_type_filters = $user_alert['type_filters'];
      $string .= pakeColor::colorize(sprintf("\n\nLa parola %s è stata trovata %d volte in %s\n", 
                                            $alert_term, count($alert_results), 
                                            OppAlertTermPeer::get_filters_labels($alert_type_filters)),
                                     array('fg' => 'cyan', 'bold' => true));      
    }
    else {
      $string .= pakeColor::colorize(sprintf("La parola %s è stata trovata %d volte:\n", 
                                            $alert_term, count($alert_results)),
                                     array('fg' => 'cyan', 'bold' => true));            
    }


    foreach ($alert_results as $i => $res) {
      $string .= get_partial($res->getInternalAlertPartial(), array('result' => $res, 'term' => $alert_term));
    }
  }
  return $string;
}





