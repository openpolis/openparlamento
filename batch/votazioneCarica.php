<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$c = new Criteria();
$c->setOffset(3013213);
$c->setLimit(600000);
$votazioni = OppVotazioneHasPoliticoPeer::doSelect($c);

foreach ($votazioni as $votazione)
{
  echo "votazione: ".$votazione->getVotazioneId()." politico: ".$votazione->getPoliticoId()."\n";
  
  $c1 = new Criteria();
  $c1->add(OppVotazionePeer::ID, $votazione->getVotazioneId(), Criteria::EQUAL);
  $vot = OppVotazionePeer::doSelectOne($c1);
  
  $c2 = new Criteria();
  $c2->add(OppSedutaPeer::ID, $vot->getSedutaId(), Criteria::EQUAL);
  $seduta = OppSedutaPeer::doSelectOne($c2);
  
  $senatori_a_vita = array("1529", "1606", "1719", "1519", "1682", "1456", "1524");
  
  $c3 = new Criteria();
  $c3->add(OppCaricaPeer::POLITICO_ID, $votazione->getPoliticoId());
  
  if(!in_array($votazione->getPoliticoId(), $senatori_a_vita))
    $c3->add(OppCaricaPeer::LEGISLATURA, $seduta->getLegislatura());
  
  $carica = OppCaricaPeer::doSelectOne($c3); 
  
  $votazioneCarica = new OppVotazioneHasCarica;
  $votazioneCarica->setVotazioneId($votazione->getVotazioneId());
  $votazioneCarica->setCaricaId($carica->getId());
  $votazioneCarica->setVoto($votazione->getVoto());
  $votazioneCarica->save();
  
  echo "OK\n";
  
}

print("done.\n");

?>