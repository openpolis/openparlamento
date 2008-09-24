<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$c = new Criteria();
//$c->addJoin(OppSedutaPeer::ID, OppVotazionePeer::SEDUTA_ID, Criteria::LEFT_JOIN);
//$c->add(OppSedutaPeer::LEGISLATURA, 15, Criteria::EQUAL);
$votazioni = OppVotazionePeer::doSelect($c);

foreach ($votazioni as $votazione)
{
  $count = $votazione->getRibelliCount();	
  echo "votazione: ".$votazione->getId()." ribelli:".$count."\n";
  
  $c1 = new Criteria();
  $c1->add(OppVotazionePeer::ID, $votazione->getId(), Criteria::EQUAL);
  $voto = OppVotazionePeer::doSelectOne($c1);
  $voto->setRibelli($count);
  $voto->save();
}

?>  