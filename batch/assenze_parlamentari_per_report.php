<?php

# in input 'C' per camera e 'S' per senato

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();


$array_sedute=array();

$c=new Criteria();
$c->addJoin(OppVotazionePeer::SEDUTA_ID,OppSedutaPeer::ID);
$c->add(OppSedutaPeer::RAMO,$argv[1]);
#$c->add(OppSedutaPeer::ID,array(530,531),Criteria::IN);
$sedute=OppSedutaPeer::doSelect($c);
foreach ($sedute as $seduta)
{
	if (!array_key_exists ($seduta->getId(),$array_sedute ))
	{
		$array_sedute[$seduta->getId()]=1;
	}
	else
	{
		$array_sedute[$seduta->getId()]=$array_sedute[$seduta->getId()]+1;
	}
}
$parl_sedute=array();
$c=new Criteria();
$c->addJoin(OppCaricaPeer::POLITICO_ID,OppPoliticoPeer::ID);
if ($argv[1]=='S')
	$c->add(OppCaricaPeer::TIPO_CARICA_ID,array(4,5),Criteria::IN);
else
	$c->add(OppCaricaPeer::TIPO_CARICA_ID,1);
$pars=OppCaricaPeer::doSelect($c);
foreach ($pars as $par)
{
	foreach (array_keys($array_sedute) as $k)
	{
		$c=new Criteria();
		$c->addJoin(OppVotazioneHasCaricaPeer::CARICA_ID,OppCaricaPeer::ID);
		$c->addJoin(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,OppVotazionePeer::ID);
		$c->add(OppCaricaPeer::ID,$par->getId());
		$c->add(OppVotazionePeer::SEDUTA_ID,$k);
		$vots=OppVotazioneHasCaricaPeer::doSelect($c);
		if (count($vots)>0)
		{
			$cn=0;
			foreach ($vots as $vot)
			{
				if ($vot->getVoto()=='Assente')
					$cn=$cn+1;
			}
			$parl_sedute[$par->getId()][$k]=round($cn*100/count($vots),2);
		}
		else
		{
			$parl_sedute[$par->getId()][$k]='N.D.';
		}
	}
}
echo ';';
foreach (array_keys($array_sedute) as $k)
{
	echo OppSedutaPeer::retrieveByPk($k)->getNumero().';';
}
echo "\n";
foreach ($parl_sedute as $pk => $ps)
{
	echo OppCaricaPeer::retrieveByPk($pk)->getOppPolitico()->getCognome().' '.OppCaricaPeer::retrieveByPk($pk)->getOppPolitico()->getNome();
	foreach ($ps as $sk=> $s)
	{
		echo ';'.$s;
		#echo $pk.';'.$sk.';'.$s."\n";
	}
	echo "\n";
}

?>