<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$testo="";

$c = new Criteria();
$c->add(OppAttoPeer::TIPO_ATTO_ID, 1);
$c->add(OppAttoPeer::RAMO, 'C');
$rss = OppAttoPeer::doSelect($c);

foreach ($rss as $rs) {

	$c = new Criteria();
	$c->add(OppDocumentoPeer::ATTO_ID, $rs->getId());
	$docs = OppDocumentoPeer::doSelect($c);
	if (count($docs)>1) {
		foreach ($docs as $doc) {
	
			$testo=$testo.$rs->getId()." - ".$doc->getTitolo()."\n";
		}
		$testo=$testo. "------------ \n";	
	
	}
	
}	


echo $testo;
mail("e.dicesare@depp.it", "ERRORE - Comunicati Governo", $testo, "From: ScriptVotazioniSenato");

?> 