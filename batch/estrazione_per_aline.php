<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$keys=array('%immigrazione%' ,'%emergenza%' ,'%migranti%' ,'%clausola di flessibilità%' ,'%clausole di flessibilità%' ,'%flessibilità%' ,'%obiettivo di medio termine%' ,'%raccomandazione ue%' ,'%sisma%' ,'%ricostruzione%' ,'%piano nazionale delle riforme%' ,'%sicurezza%' ,'%documento programmatico di bilancio%');
//$keys=array('%immigrazione%', '%migranti%');

$atti=array();
$chiave=array();
$stampa="stringa_ricerca\ttipo_atto\tnumero_atto\tramo\tdata_presentazione\tprimo_firmatario\tgruppo\turl_documento\ttags\n";

foreach ($keys as $key)
{
	$c= new Criteria();
	$c->addJoin(OppAttoPeer::ID, OppDocumentoPeer::ATTO_ID);
	$c->addJoin(OppAttoPeer::ID, OppCaricaHasAttoPeer::ATTO_ID);
	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasAttoPeer::CARICA_ID);
	$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
	$c->addJoin(OppAttoPeer::TIPO_ATTO_ID, OppTipoAttoPeer::ID);
	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID);
	$c->addJoin(OppGruppoPeer::ID, OppCaricaHasGruppoPeer::GRUPPO_ID);
	$c->add(OppAttoPeer::DATA_PRES, '2015-01-01', Criteria:: GREATER_EQUAL);
	$c->add(OppAttoPeer::TIPO_ATTO_ID, array(4,5,6), Criteria:: IN);
	$c->add(OppCaricaHasAttoPeer::TIPO, 'P');
	$c->add(OppCaricaHasGruppoPeer::DATA_FINE, NULL, Criteria::ISNULL);
	$c->add(OppDocumentoPeer::TESTO, $key, Criteria:: LIKE);
	$results=OppCaricaHasAttoPeer::doSelect($c);
	foreach ($results as $result)
	{
		if (!in_array($result,$atti))
		{
			$atti[]=$result;
			$chiave[]=$key;
		}
	}
}
foreach ($atti as $k=>$atto)
{
	$c=new Criteria();
	$c->addJoin(OppAttoPeer::ID, OppDocumentoPeer::ATTO_ID);
	$c->add(OppAttoPeer::ID, $atto->getOppAtto()->getId());
	$doc=OppDocumentoPeer::doSelectOne($c);
	
	$c=new Criteria();
	$c->addJoin(OppCaricaPeer::ID, OppCaricaHasGruppoPeer::CARICA_ID);
	$c->addJoin(OppGruppoPeer::ID, OppCaricaHasGruppoPeer::GRUPPO_ID);
	$c->add(OppCaricaPeer::ID, $atto->getOppCarica()->getId());
	$c->add(OppCaricaHasGruppoPeer::DATA_FINE, NULL, Criteria::ISNULL);
	$gruppo=OppGruppoPeer::doSelectOne($c);
	if ($gruppo)
		$nome_gruppo=$gruppo->getNome();
	else
		$nome_gruppo='';
	
	$c=new Criteria();
	$c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
	$c->addJoin(TagPeer::ID, TaggingPeer::TAG_ID);
	$c->add(TaggingPeer::TAGGABLE_MODEL, 'OppAtto');
	$c->add(OppAttoPeer::ID, $atto->getOppAtto()->getId());
	$tags=TagPeer::doSelect($c);
	$tag='';
	foreach ($tags as $t)
	{
		$tag=$tag.'|'.$t->getTripleValue();
	}
	
	$stampa=$stampa. trim($chiave[$k],'%')."\t".$atto->getOppAtto()->getOppTipoAtto()->getDenominazione()."\t".$atto->getOppAtto()->getNumfase()."\t".$atto->getOppAtto()->getRamo()."\t".$atto->getOppAtto()->getDataPres()."\t".$atto->getOppCarica()->getOppPolitico()->getCognome()."/".$atto->getOppCarica()->getOppPolitico()->getNome()."\t".$nome_gruppo."\t"."https://parlamento17.openpolis.it/atto/documento/id/".$doc->getId()."\t".trim($tag,'|')."\n";
}

print $stampa;




?>