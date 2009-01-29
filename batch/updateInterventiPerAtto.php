<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n\n");

$c = new Criteria();
$atti = OppAttoPeer::doSelect($c);
$natti = count($atti);

print ("n: " . $natti . "\n");
foreach ($atti as $i => $atto)
{
  $atto->setNInterventi($atto->countOppInterventos());
  $atto->save();
  if ($i % 10 == 0) print ".";
  if ($i % 100 == 0) print "$i/$natti\n";
}


print("done.\n");

?>