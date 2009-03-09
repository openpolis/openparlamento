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
 * @subpackage Task that checks and removes news related to non-existing objects
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("checks and removes news related to non-existing objects");
pake_task('opp-news-clean', 'project_exists');

/**
* Check and remove news related to non-existing objects
*/
function run_opp_news_clean($task, $args)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
    define('SF_APP', 'fe');
    define('SF_ENVIRONMENT', 'task');
    define('SF_DEBUG', true);

    require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.
                 DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.
                 DIRECTORY_SEPARATOR.'config.php');

    sfContext::getInstance();
    sfConfig::set('pake', true);
    
    error_reporting(E_ALL);

    $loaded = true;
  }


  $start_time = microtime(true);

  $c = new Criteria();
  $c->clearSelectColumns();
  $c->addSelectColumn(NewsPeer::ID);
  $c->addSelectColumn(NewsPeer::RELATED_MONITORABLE_MODEL);
  $c->addSelectColumn(NewsPeer::RELATED_MONITORABLE_ID);
  $n_news = NewsPeer::doCount($c);
  $rs = NewsPeer::doSelectRS($c);
  $k = 0;
  $newsids_to_remove = array();
  $removed_news = 0;
  while ($rs->next())
  {
    $news = array();
    $news['id'] = $rs->getInt(1);
    $news['rel_model'] = $rs->getString(2);
    $news['rel_id'] = $rs->getInt(3);
    if (opp_check_single_news($news))
    {
      $newsids_to_remove []= $news['id'];
      $removed_news++;
    }

    $k++;
    if ($k % 100 == 0) print ".";
    if ($k > 0 && $k % 1000 == 0) 
    {
      $rem = count($newsids_to_remove);
      NewsPeer::doDelete($newsids_to_remove);
      print "processed: $k/$n_news removed: $rem ($removed_news)\n";
      $newsids_to_remove = array();
    }
    
  }

  $total_time = microtime(true) - $start_time;

  echo pakeColor::colorize('All done! ', array('fg' => 'red', 'bold' => true));

  echo 'Processed ';
  echo pakeColor::colorize(count($n_news), array('fg' => 'cyan'));

  echo ' news in ';
  echo pakeColor::colorize(sprintf("%f", $total_time), array('fg' => 'cyan'));
  echo " seconds\n";

}

/**
 * check the single news and remove it if it is related to an object that does not exist
 *
 * @param string $news - News associative array
 * @return 0 if the news was ok, 1 if the related object does not exist
 * @author Guglielmo Celata
 */
function opp_check_single_news($news)
{
  // check that the related object exists
  $rel_class = $news['rel_model'].'Peer';
  $rel_id = $news['rel_id'];
  $news_id = $news['id'];
  $rel_obj = call_user_func($rel_class .'::retrieveByPK', $rel_id);
  if (!$rel_obj)
    return 1;
  else
    return 0;
}
