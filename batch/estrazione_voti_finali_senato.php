<?php

/*
- data
- titolo atto
- link opp
- totale voti favorevoli
- totale assenti
- dettaglio di assenza per ciascun gruppo (% su consistenza dei gruppi)
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$gruppi_tot=array();
$c = new Criteria();
$c->addJoin(OppGruppoPeer::ID, OppGruppoRamoPeer::GRUPPO_ID);
$c->add(OppGruppoRamoPeer::RAMO, 'S');
$gruppi_all=OppGruppoPeer::doSelect($c);
foreach ($gruppi_all as $k=>$g)
{
	$array_tot[$g->getId()]=$g->getAcronimo();
}
ksort($array_tot);

echo "data\ttitolo\tlink\tfavorevoli\tmargine\tassenti\t";
foreach ($array_tot as $s)
{
	echo $s."\t";
}
echo "\n";

$c = new Criteria();
$c->addJoin(OppVotazionePeer::SEDUTA_ID,OppSedutaPeer::ID);
$c->addJoin(OppVotazionePeer::ID,OppVotazioneHasAttoPeer::VOTAZIONE_ID);
$c->addJoin(OppAttoPeer::ID,OppVotazioneHasAttoPeer::ATTO_ID);
$c->add(OppSedutaPeer::RAMO,'S');
$c->add(OppAttoPeer::TIPO_ATTO_ID,1);
$c->add(OppVotazionePeer::FINALE,1);
//$c->setLimit(1);
$results=OppVotazioneHasAttoPeer::doSelect($c);
foreach ($results as $r)
{
	$gruppi=array();
	$c = new Criteria();
	$c->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $r->getVotazioneId());
	$c->add(OppVotazioneHasCaricaPeer::VOTO,'Assente');
	$cn= OppVotazioneHasCaricaPeer::doCount($c);
	$pols= OppVotazioneHasCaricaPeer::doSelect($c);
	foreach ($pols as $p)
	{
		$gruppo=OppCaricaHasGruppoPeer::getGruppoPerParlamentareAllaData($p->getCaricaId(), $r->getOppVotazione()->getOppSeduta()->getData());
		if (array_key_exists($gruppo['gruppo_id'], $gruppi))
			$gruppi[$gruppo['gruppo_id']]=$gruppi[$gruppo['gruppo_id']]+1;
		else
			$gruppi[$gruppo['gruppo_id']]=1;
		
	}
	echo $r->getOppVotazione()->getOppSeduta()->getData()."\t".$r->getOppAtto()->getTitolo()."\t"."https://parlamento17.openpolis.it/votazione/".$r->getOppVotazione()->getId()."\t".$r->getOppVotazione()->getFavorevoli()."\t".$r->getOppVotazione()->getMargine()."\t".$cn."\t";
	foreach($array_tot as $k=>$g)
	{
		if (array_key_exists($k, $gruppi))
		{
			$cn_gruppo=OppCaricaHasGruppoPeer::getNumeroParlamentariGruppoRamoData($k, $r->getOppVotazione()->getOppSeduta()->getData(),'S');
			$cn_gruppo= $cn_gruppo['count(*)'];
			echo number_format((($gruppi[$k]*100)/$cn_gruppo),1)."\t";
		}
		else
			echo "0\t";
		
	}
	echo "\n";
}

?>