<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$arr_leggi=array();
$arr_noleggi=array();

#calcola differebza in gg tra due date
function delta_tempo ($data_iniziale,$data_finale,$unita)
{
 
$data1 = strtotime($data_iniziale);
$data2 = strtotime($data_finale);
 
	switch($unita) {
		case "m": $unita = 1/60; break; 	//MINUTI
		case "h": $unita = 1; break;		//ORE
		case "g": $unita = 24; break;		//GIORNI
		case "a": $unita = 8760; break;         //ANNI
	}
 
 $differenza = (($data2-$data1)/3600)/$unita;
 return intval($differenza);
}

#prende il primo atto presentato
function get_pred($atto)
{
	$pred=OppAttoPeer::retrieveByPk($atto->getOppAtto()->getPred());
	while (count($pred)==1)
	{
		$data_pres=$pred->getDataPres();
		$pred=OppAttoPeer::retrieveByPk($pred->getPred());
	}
	return $data_pres;
}

function get_approvazioni_pred($atto)
{
	$date='';
	$predecessore=OppAttoPeer::retrieveByPk($atto->getOppAtto()->getPred());
	while (count($predecessore)==1)
	{
		$k= new Criteria();
		$k->add(OppAttoHasIterPeer::ATTO_ID, $predecessore->getId());
		$k->add(OppAttoHasIterPeer::ITER_ID, array(20,22,25), Criteria::IN);
		$k->addAscendingOrderByColumn(OppAttoHasIterPeer::ID);
		$appr=OppAttoHasIterPeer::doSelect($k);
		foreach ($appr as $d)
			#echo $atto->getOppAtto()->getId().';'.$d->getId().';'.$d->getData()."\n";
			$date=$date.';'.$d->getData();
		$predecessore=OppAttoPeer::retrieveByPk($predecessore->getPred());
	}
	return trim($date,";");
}

#prende tutti i successori
function get_all_succ($atto)
{
	$atti=array();
	$c = new Criteria();
	// escludi gli atti assorbiti
	$c->add(OppAttoHasIterPeer::ATTO_ID, $atto->getId());
	$c->add(OppAttoHasIterPeer::ITER_ID, 11);
	$cn=OppAttoHasIterPeer::doCount($c);
		
	if ($cn==0)
	{
		$succ=OppAttoPeer::retrieveByPk($atto->getSucc());
		while (count($succ)==1)
		{
			$atti[]=$succ->getId();
			$succ=OppAttoPeer::retrieveByPk($succ->getSucc());
		}
	}
	return $atti;
}

#main
$c = new Criteria();
$c->addJoin(OppAttoHasIterPeer::ATTO_ID, OppAttoPeer::ID);
$c->add(OppAttoHasIterPeer::ITER_ID, array(15,16), Criteria::IN);
$c->add(OppAttoPeer::TIPO_ATTO_ID, 1);
$modifiche=OppAttoHasIterPeer::doSelect($c);

foreach ($modifiche as $modifica)
{
	$data_presentazione=get_pred($modifica);
	$date_approvazioni=get_approvazioni_pred($modifica);
	echo $modifica->getOppAtto()->getId().';'.$modifica->getOppAtto()->getTitolo().';'.$data_presentazione.';'.$date_approvazioni.';'.$modifica->getData()."\n";
	/*
	$atti=get_all_succ($modifica->getOppAtto());
	$legge=0;
	foreach ($atti as $atto)
	{
		$c = new Criteria();
		$c->add(OppAttoHasIterPeer::ITER_ID, array(15,16), Criteria::IN);
		$c->add(OppAttoHasIterPeer::ATTO_ID, $atto);
		$succ=OppAttoHasIterPeer::doSelectOne($c);
		if ($succ)
		{
			$legge=1;
			if ($succ->getIterId()==16)
			{
				$k=new Criteria();
				$k->add(OppAttoHasIterPeer::ITER_ID,15);
				$k->add(OppAttoHasIterPeer::ATTO_ID, $succ->getOppAtto()->getId());
				$ddl_temp=OppAttoHasIterPeer::doSelectOne($k);
				if ($ddl_temp)
					$ddl=$ddl_temp;
				else
					$ddl=$succ;
				$pubb='SI';
			}
			else
			{
				$ddl=$succ;
				$k=new Criteria();
				$k->add(OppAttoHasIterPeer::ITER_ID,16);
				$k->add(OppAttoHasIterPeer::ATTO_ID, $succ->getOppAtto()->getId());
				$ddl_temp=OppAttoHasIterPeer::doSelectOne($k);
				if ($ddl_temp)
					$pubb='SI';
				else
					$pubb='NO';
			}
			if ($ddl)
			{
				if (!array_key_exists($ddl->getOppAtto()->getId(),$arr_leggi))
				{
					$giorni=delta_tempo(get_pred($ddl),$ddl->getData(),"g");
					$date_approvazioni=get_approvazioni_pred($ddl);
					$date_approvazioni=$ddl->getData().';'.$date_approvazioni;
					$arr_leggi[$ddl->getOppAtto()->getId()]= $ddl->getOppAtto()->getId()."\t".$ddl->getOppAtto()->getRamo()."\t".$ddl->getOppAtto()->getNumfase()."\t".$ddl->getOppAtto()->getTitolo()."\t".$pubb."\t".$date_approvazioni."\t".$giorni;
					break;
				}
			}
			else
				echo $succ->getOppAtto()->getId()."\n";
			
		}
	}
	if ($legge==0)
	{
		if (!array_key_exists($modifica->getOppAtto()->getId(),$arr_noleggi))
		{
			$arr_noleggi[$modifica->getOppAtto()->getId()]= $modifica->getOppAtto()->getId()."\t".$modifica->getOppAtto()->getRamo()."\t".$modifica->getOppAtto()->getNumfase()."\t".$modifica->getOppAtto()->getTitolo()."\t".$modifica->getData();
		}
	}
	*/
}
/*
if ($argv[1]==1)
{
	foreach ($arr_leggi as $a)
		echo $a."\n";
}
else
{
	foreach ($arr_noleggi as $a)
		echo $a."\n";
}
*/


?>