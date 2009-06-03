<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Add created_at informations to the sf_tagging table
 * the field takes a value equal to a random timestamp between 3 and 9 hours after
 * the creation of the tagged object's creation date
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



$tot_cnt = 0;
echo "Fetching taggings to fix\n";
$c = new Criteria();
$c->add(TaggingPeer::CREATED_AT, null, Criteria::ISNULL);
$taggings = TaggingPeer::doSelect($c);

echo "Found " . count($taggings) . " taggings\n";
foreach ($taggings as $i => $tagging) {
  if (is_null($tagging->getCreatedAt()))
  {
    $atto = $tagging->getTaggedAtto();
    if ($atto instanceof OppAtto)
    {
      $lap = rand(3 * 3600, 9 * 3600);
      $tagging->setCreatedAt($atto->getCreatedAt('U') + $lap);
      $tagging->save();      
    }
  }
  if ($i % 100 == 0) echo $i . " ";
}
  
echo "\n$i taggings processed and fixed\n";
