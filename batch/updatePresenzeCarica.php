<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$leg=16;

print("Fetching data... \n");

// DEPUTATI E SENATORI
$c = new Criteria();
$crit0 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 1);
$crit1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 4);

$crit0->addOr($crit1);
$crit2 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $leg);

$crit0->addAnd($crit2);
$crit3 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 5);
$crit4 = $c->getNewCriterion(OppCaricaPeer::DATA_FINE, NULL, Criteria::ISNULL);

$crit3->addAnd($crit4);

$crit0->addOr($crit3);

$c->add($crit0);

$cariche = OppCaricaPeer::doSelect($c);



foreach ($cariche as $carica) 
{
	  
  $c=new Criteria();
  $c->add(OppCaricaHasGruppoPeer::CARICA_ID,$carica->getId());
  $rs=OppCaricaHasGruppoPeer::doSelect($c);
  foreach ($rs as $r)
  {
    $r->setPresenze(0);
    $r->save();
    

  	$c = new Criteria();
  	$c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,OppVotazionePeer::ID);
  	$c->addJoin(OppVotazionePeer::SEDUTA_ID,OppSedutaPeer::ID);
  	if ($r->getDataFine()!==NULL)
  	{
  	  $crit0 = $c->getNewCriterion(OppSedutaPeer::DATA, $r->getDataInizio(), Criteria::GREATER_EQUAL);
      $crit1 = $c->getNewCriterion(OppSedutaPeer::DATA, $r->getDataFine(), Criteria::LESS_THAN);
      $crit0->addAnd($crit1);
      $c->add($crit0);
  	}
  	else
  	  	$c->add(OppSedutaPeer::DATA,$r->getDataInizio(),Criteria::GREATER_EQUAL);

  	  
  	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$carica->getId());
  	$c->add(OppVotazioneHasCaricaPeer::VOTO,array('Assente','In missione', 'Votazione annullata'), Criteria::NOT_IN);
  	
  	echo $pres1 = OppVotazioneHasCaricaPeer::doCount($c);
  	echo "\n";
    
    $r->setPresenze($pres1);
    $r->save();
  }
  
  $c = new Criteria();
	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$carica->getId());
	$c->add(OppVotazioneHasCaricaPeer::VOTO,array('Assente','In missione', 'Votazione annullata'), Criteria::NOT_IN);
	$pres = OppVotazioneHasCaricaPeer::doCount($c);	
	$c = new Criteria();
	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$carica->getId());
	$c->add(OppVotazioneHasCaricaPeer::VOTO,'Assente');
	$ass = OppVotazioneHasCaricaPeer::doCount($c);
	$c = new Criteria();
	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$carica->getId());
	$c->add(OppVotazioneHasCaricaPeer::VOTO,'In missione');
	$miss = OppVotazioneHasCaricaPeer::doCount($c);
	
	$carica->setPresenze($pres);
	$carica->setAssenze($ass);
	$carica->setMissioni($miss);
	$carica->save();	
				
	echo $carica->getOppPolitico()->getCognome()." pres. ".$pres." ass. ".$ass." miss. ".$miss."\n";
}


mail("e.dicesare@depp.it", "OK - Update Presenze", "aggiornamento a buon fine", "From: BatchOpp");

?>

