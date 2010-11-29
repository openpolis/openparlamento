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
 * @subpackage Task that fetch today's news for objects monitored by subscribers and send them by emails
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */

pake_desc("fetch today's news for subscribers and send them via e-mail");
pake_task('opp-send-newsletter', 'project_exists');

pake_desc("test newsletter production");
pake_task('opp-test-newsletter', 'project_exists');

/**
* Fetch news and send them via e-mail
*/
function run_opp_send_newsletter($task, $args, $options)
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
    sfLoader::loadHelpers(array('Tag', 'Url', 'DeppNews'));
    sfConfig::set('pake', true);
    
    error_reporting(E_ALL);

    $loaded = true;
  }

  $date = null;
  if (array_key_exists('date', $options))
    $date = $options['date'];


  $start_time = microtime(true);

  $c = new Criteria();
  $c->add(OppUserPeer::WANTS_OPP_NEWS, 1);
  $c->add(OppUserPeer::IS_ACTIVE, 1);
  $c->addJoin(MonitoringPeer::USER_ID, OppUserPeer::ID);
  if (count($args)) {
    $c->add(OppUserPeer::ID, $args, Criteria::IN);
  }
  $c->addGroupByColumn(OppUserPeer::ID);
  $users = OppUserPeer::doSelect($c);

  $n_users = count($users);
  foreach ($users as $cnt => $user)
  {
    echo "$cnt/$n_users ";
    opp_send_single_newsletter($user, $date);
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
 * fetch today's news regarding objects monitored by the user
 *
 * @param string $user - OppUser object
 * @return void
 * @author Guglielmo Celata
 */
function opp_send_single_newsletter($user, $date = null)
{
  $start_time = microtime(true);

  echo pakeColor::colorize(sprintf('Processing user %s...', $user), 
                           array('fg' => 'cyan', 'bold' => true));


  // invoke the action that sends the email
  sfContext::getInstance()->getRequest()->setParameter('user_id', $user->getId());
  sfContext::getInstance()->getRequest()->setParameter('date', $date);
  
  try {
    $raw_email = sfContext::getInstance()->getController()->sendEmail('monitoring', 'sendNewsletter');
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
function run_opp_test_newsletter($task, $args, $options)
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
    sfLoader::loadHelpers(array('Tag', 'Url', 'DeppNews'));
    sfConfig::set('pake', true);
    
    error_reporting(E_ALL);

    $loaded = true;
  }

  $date = null;
  if (array_key_exists('date', $options))
    $date = $options['date'];
    
  $start_time = microtime(true);
  echo pakeColor::colorize("Hi, there!\n", array('fg' => 'green', 'bold' => true));

  // fetch utenti attivi che monitorano qualcosa e vogliono le news
  $c = new Criteria();
  $c->add(OppUserPeer::WANTS_OPP_NEWS, 1);
  $c->add(OppUserPeer::IS_ACTIVE, 1);
  $c->addJoin(MonitoringPeer::USER_ID, OppUserPeer::ID);
  if (count($args)) {
    $c->add(OppUserPeer::ID, $args, Criteria::IN);
  }
  $c->addGroupByColumn(OppUserPeer::ID);
  $users = OppUserPeer::doSelect($c);

  $n_users = count($users);
  echo pakeColor::colorize("$n_users users are monitoring. Here are the news we would send them.\n", array('fg' => 'green'));
  foreach ($users as $cnt => $user)
  {
    echo "$cnt/$n_users ";
    opp_test_single_newsletter($user, $date);
  }
  
  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Processed ';
  echo pakeColor::colorize(count($users), array('fg' => 'cyan'));

  echo ' users in ';
  echo pakeColor::colorize(sprintf("%f", $total_time), array('fg' => 'cyan'));
  echo " seconds\n";

}

/**
 * fetch today's news regarding objects monitored by the user
 * today's news are last 24h's news
 *
 * @param string $user - OppUser object
 * @return void
 * @author Guglielmo Celata
 */
function opp_test_single_newsletter($user, $date = null)
{
  $start_time = microtime(true);
  
  $df = new sfDateFormat('it_IT');

  echo pakeColor::colorize(sprintf('date: %s, name: %s... ', is_null($date)?'Today':$date, $user), 
                           array('fg' => 'red', 'bold' => true));


  $news_c = oppNewsPeer::getTodayNewsForUserCriteria($user, $date);
  $news_c->add(oppNewsPeer::PRIORITY, 2, Criteria::LESS_EQUAL);
  $news = oppNewsPeer::doSelect($news_c);

  // raggruppa le news per data
  $grouped_news = array();
  foreach ($news as $n)
  {
    $date = strtotime($n->getDate());
    if (!is_string($date) && !is_int($date))
      $date = 0;

    if (!array_key_exists($date, $grouped_news))
    {
      $grouped_news[$date] = array();        
    }
    $grouped_news[$date] []= $n;
  }
  krsort($grouped_news);
  
  echo pakeColor::colorize(sprintf("(%d)\n", count($news)), array('fg' => 'cyan'));
  if (count($news) > 0)
  {
    echo pakeColor::colorize(sprintf("\t    |        ID | CREATED_AT      | REL_MODEL |    REL_ID |      GENERATOR_MODEL | P |\n"), 
                                     array('fg' => 'cyan', 'bold' => true));
    
  }
  foreach ($grouped_news as $date_ts => $news)
  {
    echo pakeColor::colorize(sprintf("%2d/%3s/%4d\n", 
                             $df->format($date_ts, 'dd'), 
                             $df->format($date_ts, 'MMM'), 
                             $df->format($date_ts, 'yyyy')),
                             array('fg' => 'cyan', 'bold' => true));
    foreach ($news as $i => $n) {
      echo pakeColor::colorize(sprintf("\t%3d | %9d | %10s | %10s | %9d | %20s | %1d |\n", 
                                       $i+1, $n->getId(), $n->getCreatedAt('y-m-d H:i'), 
                                       $n->getRelatedMonitorableModel(), $n->getRelatedMonitorableId(), 
                                       $n->getGeneratorModel(), $n->getPriority()));
    }
  }
  echo "\n";
  
   
  $execution_time = microtime(true) - $start_time;
  if (isset($raw_email) && $raw_email != '') echo " ok (";
  else echo " no mail (";
  echo pakeColor::colorize(sprintf("%f", $execution_time), array('fg' => 'cyan'));
  echo ")\n";
}



