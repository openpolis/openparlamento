<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

// le carica_id dei componenti di intergruppo innovazione
$cariche=array(686812,686655,686382,687579,686709,686731,687389,686270,686282,686928,686245,686107,686420,686794,686783,686906,687364,686102,686136,687381,686379,686480,686675,686388,686383,686952,686255,686855,686661,686547,686696,686343,686472,686938,686859,686978,687740,686209,687319,686819,686299,686981,687370,687007,686358,687276,686738,686291,686553,687393,687356,686178,686345,686759,687101,686316,687001,686823,686317,686280,686919,687348,686295,687373,686272,686124,687727,686249,686232,689453,686882,686370,686304,686991,686921,686510,686165,686298,687290,686311,686943,687399,687273,686153,686478,687034,686408,686751,687317,686357,686248,686161,686414,686513,687331);

$atti=array();

foreach ($cariche as $carica)
{
	$c = new Criteria();
	$c->addJoin(OppCaricaHasAttoPeer::ATTO_ID,OppAttoPeer::ID);
	$c->add(OppCaricaHasAttoPeer::CARICA_ID,$carica);
	$c->add(OppCaricaHasAttoPeer::TIPO,array("P","C"),Criteria::IN);
	//$c->add(OppCaricaHasAttoPeer::ATTO_ID,"24472");
	$c->addAscendingOrderByColumn(OppAttoPeer::TIPO_ATTO_ID);
	$firmeCarica=OppCaricaHasAttoPeer::doSelect($c);
	foreach ($firmeCarica as $firmaCarica)
	{
		$c= new Criteria();
		$c->add(OppCaricaHasAttoPeer::ATTO_ID,$firmaCarica->getAttoId());
		$c->add(OppCaricaHasAttoPeer::CARICA_ID,array_diff($cariche, array($carica)),Criteria::IN);
		$c->add(OppCaricaHasAttoPeer::TIPO,array("P","C"),Criteria::IN);
		$firme=OppCaricaHasAttoPeer::doSelect($c);
		foreach ($firme as $firma)
		{			
			if (OppCaricaHasGruppoPeer::getGruppoPerParlamentareAllaData($carica, $firma->getOppAtto()->getDataPres(), $con = null)!=OppCaricaHasGruppoPeer::getGruppoPerParlamentareAllaData($firma->getCaricaId(), $firma->getOppAtto()->getDataPres(), $con = null))
			{
				//echo $firma->getCaricaId()."\n";
				if (!in_array($firma->getAttoId(),$atti))
				{
					$atti[]=$firma->getAttoId();
					break;
				}
			}
		}
	}
	
}
$csv="Tipo Atto\tNumero\tTitolo\tData Presentazione\tStato\tN. Firme Inn.\tPrimo firmatario?\tFirmatari\tUrl_testo\n";
foreach ($atti as $attoId)
{
	$atto=OppAttoPeer::retrieveByPk($attoId);
	$c= new Criteria();
	$c->add(OppCaricaHasAttoPeer::ATTO_ID,$attoId);
	$c->add(OppCaricaHasAttoPeer::CARICA_ID,$cariche,Criteria::IN);
	$c->add(OppCaricaHasAttoPeer::TIPO,array("P","C"),Criteria::IN);
	$c->addDescendingOrderByColumn(OppCaricaHasAttoPeer::TIPO);
	$firmatari=OppCaricaHasAttoPeer::doSelect($c);
	$firme_text="";
	$primo_firmatario=0;
	foreach ($firmatari as $firmatario)
	{
		if ($firmatario->getTipo()=="P")
			$primo_firmatario=1;
		$firme_text=$firme_text.";".$firmatario->getOppCarica()->getOppPolitico()->getCognome()." ".$firmatario->getOppCarica()->getOppPolitico()->getNome()." (".$firmatario->getTipo().")";
	}
	$c = new Criteria();
	$c->add(OppDocumentoPeer::ATTO_ID,$attoId);
	$doc=OppDocumentoPeer::doSelectOne($c);
	if ($doc)
	{
		if ($doc->getUrlPdf()!==NULL)
			$url=$doc->getUrlPdf();
		else
		{
			if ($doc->getUrlTesto()!==NULL)
				$url=$doc->getUrlTesto();
			else
				$url='http://parlamento17.openpolis.it/atto/documento/id/'.$doc->getId();
		}
	}
	else
		$url='';
	$titolo=$atto->getTitolo();
	if (substr_count($titolo,'<br />approvato con il nuovo titolo<br />')==1)
	{
		$titolo=explode('<br />approvato con il nuovo titolo<br />',$titolo);
		$titolo=$titolo[1];
	}
	$titolo=str_replace('"','',$titolo);
	$csv=$csv.ltrim($atto->getOppTipoAtto()->getDenominazione(),"S")."\t".$atto->getRamo().".".$atto->getNumfase()."\t".$titolo."\t".$atto->getDataPres()."\t".$atto->getStatoFase()."\t".count($firmatari)."\t".$primo_firmatario."\t".trim($firme_text,";")."\t".$url."\n";
}
echo $csv;
?>