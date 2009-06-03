<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * find all taggings related to a non-existing opp_atto record and remove them
 *
 */
?>
<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();



$cnt = 0;
echo "Processing all taggings\n";
$c = new Criteria();
$taggings = TaggingPeer::doSelect($c);

foreach ($taggings as $i => $tagging) {
  $atto = $tagging->getTaggedAtto();
  if (!$atto instanceof OppAtto)
  {
    $cnt++;
    echo $tagging->getID() . " - " . $tagging->getTaggableId() . "\n";
    $tagging->delete();
  }
}
  
echo "\n$i taggings processed ($cnt broken links deleted)\n";
