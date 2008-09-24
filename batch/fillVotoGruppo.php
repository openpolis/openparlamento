<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();


$c = new Criteria();
$c->addJoin(OppSedutaPeer::ID, OppVotazionePeer::SEDUTA_ID, Criteria::LEFT_JOIN);
//$c->add(OppSedutaPeer::LEGISLATURA, '15', Criteria::EQUAL);
$c->add(OppSedutaPeer::LEGISLATURA, '16', Criteria::EQUAL);
$votazioni = OppVotazionePeer::doSelect($c);

foreach($votazioni as $votazione)
{
  print "elaborazione votazione: " . $votazione->getId() . "...\n";
  
  $c = new Criteria();
  $c->add(OppSedutaPeer::ID, $votazione->getSedutaId(), Criteria::EQUAL);
  $seduta = OppSedutaPeer::doSelectOne($c);
	
  $c = new Criteria();
  $c->add(OppLegislaturaHasGruppoPeer::LEGISLATURA, $seduta->getLegislatura(), Criteria::EQUAL);
  $c->add(OppLegislaturaHasGruppoPeer::RAMO, $seduta->getRamo(), Criteria::EQUAL);
  $gruppi_votazione = OppLegislaturaHasGruppoPeer::doSelect($c);
  
  foreach ($gruppi_votazione as $gruppo)
  {	
	$gr = OppGruppoPeer::retrieveByPk($gruppo->getGruppoId());
	  	  
	$voto_gruppo = OppVotazionePeer::doSelectVotoGruppo($votazione->getId(), $gr->getNome());	
	
    $votazioneGruppo = new OppVotazioneHasGruppo;
    $votazioneGruppo->setVotazioneId($votazione->getId());
    $votazioneGruppo->setGruppoId($gr->getId());
    $votazioneGruppo->setVoto($voto_gruppo);
    $votazioneGruppo->save();
	  
	print $gr->getNome().": ".$voto_gruppo."\n";	  
  }	
  
}

print("done.\n");

?>