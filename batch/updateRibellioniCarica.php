<?php
/*
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'task');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n\n");

echo $legislatura_corrente = OppLegislaturaPeer::getCurrent();
$data = date('Y-m-d');
$parlamentari_rs = OppCaricaPeer::getParlamentariRamoDataRS('parlamento', $legislatura_corrente, $data);    

while ($parlamentari_rs->next()) 
{
  $p = $parlamentari_rs->getRow();
  $carica_id = $p['id'];
  $gruppo = OppCaricaPeer::getGruppo($carica_id, $data);
  $gruppo_id = $gruppo['id'];
  $gruppo_obj = OppCaricaHasGruppoPeer::retrieveByPK($carica_id, $gruppo_id);
  if (is_null($gruppo_obj)) 
  {
    printf("WARNING: NESSUN RECORD: carica: %d, gruppo: %d\n", $carica_id, $gruppo_id);     
    continue; 
  }
  $n_ribellioni = OppVotazioneHasCaricaPeer::countRibellioniCaricaData($p['id'], $legislatura_corrente, $data, $gruppo_obj->getDataInizio());
  $gruppo_obj->setRibelle($n_ribellioni);
  $gruppo_obj->save();
  printf("carica: %d, gruppo: %d, n_ribellioni: %d\n", $carica_id, $gruppo_id, $n_ribellioni);  
}

// mail("e.dicesare@depp.it", "OK - Update Ribellioni", "aggiornamento a buon fine", "From: BatchOpp");	
*/


define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

include ("utility/notify.php");

echo $leg=$argv[1];

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
  	$c->add(OppVotazioneHasCaricaPeer::RIBELLE,1);
  	
  	echo $n_ribelle = OppVotazioneHasCaricaPeer::doCount($c);
  	echo "\n";
    
    $r->setRibelle($n_ribelle);
    $r->save();
  }
  
  $c = new Criteria();
	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$carica->getId());
	$c->add(OppVotazioneHasCaricaPeer::RIBELLE,1);
	$n_ribelle_tot = OppVotazioneHasCaricaPeer::doCount($c);	

	
	$carica->setRibelle($n_ribelle_tot);
	$carica->save();	
	
	echo $n_ribelle_tot."\n---\n";
				
}


notify("e.dicesare@depp.it", "OK - Update Ribellioni", "aggiornamento a buon fine", "From: BatchOpp");









?>
