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
    $crit0 = $c->getNewCriterion(OppGruppoRamoPeer::RAMO, $seduta->getRamo());
    $crit1 = $c->getNewCriterion(OppGruppoRamoPeer::DATA_INIZIO, $seduta->getData(), Criteria::LESS_EQUAL);
    $crit2 = $c->getNewCriterion(OppGruppoRamoPeer::DATA_FINE, $seduta->getData(), Criteria::GREATER_THAN);
    $crit3 = $c->getNewCriterion(OppGruppoRamoPeer::DATA_FINE, NULL, Criteria::ISNULL);
    $crit2->addOr($crit3);
    $crit0->addAnd($crit1);
    $crit0->addAnd($crit2);
    $c->add($crit0);
    $gruppi_votazione = OppGruppoRamoPeer::doSelect($c);
    
	foreach ($gruppi_votazione as $gruppo)
	{
	  $gr = OppGruppoPeer::retrieveByPk($gruppo->getGruppoId());
	  	  
	  $voto_gruppo = OppVotazionePeer::doSelectVotoGruppo($votazione->getId(), $gr->getNome());	
	 
	  $c= new Criteria();
	  $c->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID,$votazione->getId());
	  $c->add(OppVotazioneHasGruppoPeer::GRUPPO_ID,$gr->getId());
	  $result=OppVotazioneHasGruppoPeer::doSelectOne($c);
	  if ($result)
	  {
	    $result->setVoto($voto_gruppo);
	    $result->save();
	    print $gr->getNome().": ".$voto_gruppo."\n";	  
	  } 
	  else 
	  {
	    $insert = new OppVotazioneHasGruppo;
	    $insert->setVotazioneId($votazione->getId());
	    $insert->setGruppoId($gr->getId());
	    $insert->setVoto($voto_gruppo);
	    $insert->save();
	    print "++++++++++++++++ ".$gr->getNome().": ".$voto_gruppo."\n";
	    
	  }
	  
	  
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