<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c= new Criteria();
$c-> addJoin(OppSedutaPeer::ID,OppVotazionePeer::SEDUTA_ID);
$c-> add(OppVotazionePeer::TITOLO,'Votazione annullata');
$c->add(OppSedutaPeer::RAMO,'C');
$votazioni=OppVotazionePeer::doSelect($c);



echo count($votazioni); 
foreach($votazioni as $votazione) {
	$c1=new Criteria();
	$c1->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,$votazione->getId());
	$voti=OppVotazioneHasCaricaPeer::doSelect($c1);
	
	foreach ($voti as $voto) {
		$voto->setVoto('Votazione annullata');
		$voto->save();
			
	}		
}	


?>