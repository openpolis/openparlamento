<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$c = new Criteria();
$c->setOffset(959);
$c->setLimit(31);
$politici = OppSenatoriPeer::doSelect($c);
$count=1;
	
foreach ($politici as $politico)
{
  echo "id openpolis: ".$politico->getOpId()."\n";
  $c1 = new Criteria();
  $c1->Add(OppParlamentariVotazioniPeer::ID_PARLAMENTARE, $politico->getId(), Criteria::EQUAL);
  $votazioni_politico = OppParlamentariVotazioniPeer::doSelect($c1);

  foreach ($votazioni_politico as $votazione_politico)
  {
    $c2 = new Criteria();
	$c2->Add(OppVotazioneHasPoliticoPeer::POLITICO_ID, $politico->getOpId());
	$c2->Add(OppVotazioneHasPoliticoPeer::VOTAZIONE_ID, $votazione_politico->getIdVotazione());
	$controllo = OppVotazioneHasPoliticoPeer::doSelect($c2);
	if ($controllo == null)
    {
	
	echo "politico: ".$count." - votazione: ".$votazione_politico->getIdVotazione()."\n";
	$parlamentare_has_votazione = new OppVotazioneHasPolitico;
	$parlamentare_has_votazione->setPoliticoId($politico->getOpId());
	$parlamentare_has_votazione->setVotazioneId($votazione_politico->getIdVotazione());
	$parlamentare_has_votazione->setVoto($votazione_politico->getVotazione());
    $parlamentare_has_votazione->save();
	
    }
  }
  $count++;
}

print("done.\n");

?>