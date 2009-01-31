<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c = new Criteria();
$c->add(OppCaricaPeer::LEGISLATURA, 16);
$c->add(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL);

$cariche = OppCaricaPeer::doSelect($c);
$ncariche = count($cariche);
print "Processo " . $ncariche . " cariche \n";

foreach($cariche as $i => $carica)
{  

	$carica_id = $carica->getId();

  print "carica $i (".$carica_id.") ";
  passthru("php batch/updateVotiRibelliCarica.php $carica_id");

	print "\n";
    
}
print("done.\n");


?>