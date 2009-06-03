<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * find all opp_atto records with a null created_at field and set it to
 * a value equal to a random timestamp between 6 hours and 5 days after
 * the presentation's date (data_pres field)
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

echo "Fetching attos to fix\n";
$c = new Criteria();
$c->add(OppAttoPeer::CREATED_AT, null, Criteria::ISNULL);
$attos = OppAttoPeer::doSelect($c);

echo "Found " . count($attos) . " attos\n";
foreach ($attos as $i => $atto) {
  $lap = rand(6 * 3600, 120 * 3600);
  $atto->setCreatedAt($atto->getDataPres('U') + $lap);
  $atto->fastSave();      
  if ($i % 100 == 0) echo $i . " ";
}
  
echo "\n$i attos processed and fixed\n";
