<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$leg=16;

print("Fetching data... \n");

// DEPUTATI E SENATORI
$c = new Criteria();
$crit0 = $c->getNewCriterion(OppCaricaPeer::LEGISLATURA, $leg);
$crit1 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 1);
$crit2 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 4);
$crit3 = $c->getNewCriterion(OppCaricaPeer::TIPO_CARICA_ID, 5);

$crit1->addOr($crit2);
$crit1->addOr($crit3);

$crit0->addAnd($crit1);

$c->add($crit0);
$cariche = OppCaricaPeer::doSelect($c);

foreach ($cariche as $carica) {
	$pres=0;
	$ass=0;
	$miss=0;

	$c = new Criteria();
	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$carica->getId());
	$voti = OppVotazioneHasCaricaPeer::doSelect($c);
	foreach ($voti as $voto) {
			if ($voto->getVoto()=='Assente') $ass=$ass+1;
			else {
				if ($voto->getVoto()=='In missione') $miss=$miss+1;
				else $pres=$pres+1;
			}
	} 
	$carica->setPresenze($pres);
	$carica->setAssenze($ass);
	$carica->setMissioni($miss);
	$carica->save();
					
	echo $carica->getOppPolitico()->getCognome()." pres. ".$pres." ass. ".$ass." miss. ".$miss."\n";
}

//SENATORI A VITA

echo "== sen. a vita == \n";
$c = new Criteria();
$c->add(OppCaricaPeer::DATA_FINE, NULL);
$c->add(OppCaricaPeer::TIPO_CARICA_ID, 5);

$cariche = OppCaricaPeer::doSelect($c);
foreach ($cariche as $carica) {
	$pres=0;
	$ass=0;
	$miss=0;

	$c = new Criteria();
	$c->add(OppVotazioneHasCaricaPeer::CARICA_ID,$carica->getId());
	$voti = OppVotazioneHasCaricaPeer::doSelect($c);
	foreach ($voti as $voto) {
		if ($voto->getOppVotazione()->getOppSeduta()->getLegislatura()==$leg) {
			if ($voto->getVoto()=='Assente') $ass=$ass+1;
			else {
				if ($voto->getVoto()=='In missione') $miss=$miss+1;
				else $pres=$pres+1;
			}
		}	
	} 
	$carica->setPresenze($pres);
	$carica->setAssenze($ass);
	$carica->setMissioni($miss);
	$carica->save();
					
	echo $carica->getOppPolitico()->getCognome()." pres. ".$pres." ass. ".$ass." miss. ".$miss."\n";
}


?>

