<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

// le carica_id dei componenti di intergruppo innovazione
$cariche=array(686812,686655,686382,687579,686709,686731,687389,686270,686282,686928,686245,686107,686420,686794,686783,686906,687364,686102,686136,687381,686379,686480,686675,686388,686383,686952,686255,686855,686661,686547,686696,686343,686472,686938,686859,686978,687740,686209,687319,686819,686299,686981,687370,687007,686358,687276,686738,686291,686553,687393,687356,686178,686345,686759,687101,686316,687001,686823,686317,686280,686919,687348,686295,687373,686272,686124,687727,686249,686232,689453,686882,686370,686304,686991,686921,686510,686165,686298,687290,686311,686943,687399,687273,686153,686478,687034,686408,686751,687317,686357,686248,686161,686414,686513,687331);

$emendamenti=array();

foreach ($cariche as $carica)
{
	$c = new Criteria();
	$c->addJoin(OppCaricaHasEmendamentoPeer::EMENDAMENTO_ID,OppEmendamentoPeer::ID);
	$c->add(OppCaricaHasEmendamentoPeer::CARICA_ID,$carica);
	$c->add(OppCaricaHasEmendamentoPeer::TIPO,array("P","C"),Criteria::IN);
	$firmeCarica=OppCaricaHasEmendamentoPeer::doSelect($c);
	foreach ($firmeCarica as $firmaCarica)
	{
		$c= new Criteria();
		$c->add(OppCaricaHasEmendamentoPeer::EMENDAMENTO_ID,$firmaCarica->getEmendamentoId());
		$c->add(OppCaricaHasEmendamentoPeer::CARICA_ID,array_diff($cariche, array($carica)),Criteria::IN);
		$firme=OppCaricaHasEmendamentoPeer::doSelect($c);
		foreach ($firme as $firma)
		{
			
			if (OppCaricaHasGruppoPeer::getGruppoPerParlamentareAllaData($carica, $firma->getOppEmendamento()->getDataPres(), $con = null)!=OppCaricaHasGruppoPeer::getGruppoPerParlamentareAllaData($firma->getCaricaId(), $firma->getOppEmendamento()->getDataPres(), $con = null))
			{
				//echo $firma->getCaricaId()."\n";
				if (!in_array($firma->getEmendamentoId(),$emendamenti))
				{
					$emendamenti[]=$firma->getEmendamentoId();
					break;
				}
			}
		}
	}
	
}
$csv="Numero Emendamento\tData Presentazione\tN. Atto di riferimento\tTitolo Atto di riferimento\tN. Firme Inn.\tPrimo firmatario?\tFirmatari\tUrl\n";
foreach ($emendamenti as $emendamentoId)
{
	$emendamento=OppEmendamentoPeer::retrieveByPk($emendamentoId);
	$c= new Criteria();
	$c->add(OppCaricaHasEmendamentoPeer::EMENDAMENTO_ID,$emendamentoId);
	$c->add(OppCaricaHasEmendamentoPeer::CARICA_ID,$cariche,Criteria::IN);
	$c->add(OppCaricaHasEmendamentoPeer::TIPO,array("P","C"),Criteria::IN);
	$c->addDescendingOrderByColumn(OppCaricaHasEmendamentoPeer::TIPO);
	$firmatari=OppCaricaHasEmendamentoPeer::doSelect($c);
	$firme_text="";
	$primo_firmatario=0;
	foreach ($firmatari as $firmatario)
	{
		if ($firmatario->getTipo()=="P")
			$primo_firmatario=1;
		$firme_text=$firme_text.";".$firmatario->getOppCarica()->getOppPolitico()->getCognome()." ".$firmatario->getOppCarica()->getOppPolitico()->getNome()."(".$firmatario->getTipo().")";
	}
	$c= new Criteria();
	$c->add(OppAttoHasEmendamentoPeer::EMENDAMENTO_ID,$emendamentoId);
	$atto=OppAttoHasEmendamentoPeer::doSelectOne($c);
	$csv=$csv.$emendamento->getNumfase()."\t".$emendamento->getDataPres()."\t".$atto->getOppAtto()->getRamo().".".$atto->getOppAtto()->getNumfase()."\t".$atto->getOppAtto()->getTitolo()."\t".count($firmatari)."\t".$primo_firmatario."\t".trim($firme_text,";")."\t"."http://parlamento17.openpolis.it/emendamento/".$emendamento->getId()."\n";
}
echo $csv;
?>