<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

if ($argv[1])
{
  print "elaborazione votazione: " . $argv[1] . "...\n";
  $c = new Criteria();
  $c->add(OppVotazionePeer::ID, $argv[1], Criteria::EQUAL);
  $votazione = OppVotazionePeer::doSelectOne($c);
  
  if($votazione)
 
  { 
    
    
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
  else
    print "votazione non trovata";
}
else
{
  print "identificativo votazione non inserito";
}

print("done.\n");

?>