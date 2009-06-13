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
function run_opp_send_newsletter($task, $args)
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


  $start_time = microtime(true);

  $c = new Criteria();
  $c->add(OppUserPeer::WANTS_NEWSLETTER, 1);
  $users = OppUserPeer::doSelect($c);

  foreach ($users as $user)
  {
    opp_send_single_newsletter($user);
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
function opp_send_single_newsletter($user)
{
  $start_time = microtime(true);

  echo pakeColor::colorize(sprintf('Processing user %s...', $user), 
                           array('fg' => 'cyan', 'bold' => true));


  // invoke the action that sends the email
  sfContext::getInstance()->getRequest()->setParameter('user_id', $user->getId());
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
function run_opp_test_newsletter($task, $args)
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



  $start_time = microtime(true);
  echo pakeColor::colorize("Hi, there!\n", array('fg' => 'green', 'bold' => true));

  $c = new Criteria();
  $c->add(OppUserPeer::WANTS_NEWSLETTER, 1);
  $users = OppUserPeer::doSelect($c);

  foreach ($users as $user)
  {
    opp_test_single_newsletter($user);
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
 *
 * @param string $user - OppUser object
 * @return void
 * @author Guglielmo Celata
 */
function opp_test_single_newsletter($user)
{
  $start_time = microtime(true);
  
  $df = new sfDateFormat('it_IT');

  echo pakeColor::colorize(sprintf('Today\'s news for user %s... ', $user), 
                           array('fg' => 'red', 'bold' => true));


  $news = NewsPeer::fetchTodayNewsForUser($user);

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
    echo pakeColor::colorize(sprintf("\t    |        ID |        RELATED_MODEL |    REL_ID |      GENERATOR_MODEL |     DATE \n"), 
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
      echo pakeColor::colorize(sprintf("\t%03d | %09d | %20s | %09d | %20s | %10s\n", 
                                       $i, $n->getId(), $n->getRelatedMonitorableModel(), $n->getRelatedMonitorableId(), 
                                       $n->getGeneratorModel(), 
                                       $i == 0?$n->getDate('Y-m-d'):''));
    }
  }
  echo "\n";
  
   
  $execution_time = microtime(true) - $start_time;
  if (isset($raw_email) && $raw_email != '') echo " ok (";
  else echo " no mail (";
  echo pakeColor::colorize(sprintf("%f", $execution_time), array('fg' => 'cyan'));
  echo ")\n";
}



