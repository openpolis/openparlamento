<?php
/*
 * This file is part of the deppPropelMonitoringBehaviors package.
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
 * @subpackage Task that fetch today's news for objects mopnitored by subscribers and send them by emails
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("fetch today's news for subscribers and send them via e-mail");
pake_task('opp-send-newsletter', 'project_exists');

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
    define('SF_ENVIRONMENT', 'task-test');
    define('SF_DEBUG', true);

    require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

    sfContext::getInstance();
    sfLoader::loadHelpers(array('Tag', 'Url', 'DeppNews'));
    sfConfig::set('pake', true);
    
    // sign in as admin
    $user = OppUserPeer::retrieveByPK(1);
    sfContext::getInstance()->getUser()->signIn($user);

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
function opp_send_single_newsletter($user)
{
  $start_time = microtime(true);

  echo pakeColor::colorize(sprintf('Processing user %s...', $user), 
                           array('fg' => 'red', 'bold' => true));


  // invoke the action that sends the email
  sfContext::getInstance()->getRequest()->setParameter('user_id',$user->getId());
  $raw_email = sfContext::getInstance()->getController()->sendEmail('monitoring', 'sendNewsletter');

  // log the email
  sfContext::getInstance()->getLogger()->debug($raw_email);
  
  $execution_time = microtime(true) - $start_time;
  if ($raw_email != '') echo " ok (";
  else echo " no mail (";
  echo pakeColor::colorize(sprintf("%f", $execution_time), array('fg' => 'cyan'));
  echo ")\n";
}