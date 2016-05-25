<?php

/*
Calcola la similarità degli emendamenti di uno stesso disegno di legge e di uno stesso articolo
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c = new Criteria();
$c->add(OppAttoPeer::TIPO_ATTO_ID, 1);
$c->add(OppAttoPeer::ID,43980);
$atti=OppAttoPeer::doSelect($c);
foreach ($atti as $atto)
{
	$arr_articoli=array();
	
	$c= new Criteria();
	$c->addJoin(OppAttoHasEmendamentoPeer::EMENDAMENTO_ID, OppEmendamentoPeer::ID);
	$c->add(OppAttoHasEmendamentoPeer::ATTO_ID, $atto->getId());
	$emendamenti=OppEmendamentoPeer::doSelect($c);
	
	foreach($emendamenti as $emendamento)
	{
		if (in_array($emendamento->getArticolo(),$arr_articoli)==FALSE)
			$arr_articoli[]=array($emendamento->getArticolo(), $emendamento->getId());
	}
	//var_dump($arr_articoli[count($arr_articoli)-1]);
	foreach ($arr_articoli as $k=>$a)
	{
		//echo "tot=".count($arr_articoli);
		$cn=$k;
		
		
		while ($a[0]==$arr_articoli[$cn+1][0])
		{
		echo	$richiesta='curl https://api.dandelion.eu/datatxt/sim/v1/?url1=http://parlamento17.openpolis.it/emendamento/'.$a[1].'&url2=http://parlamento17.openpolis.it/emendamento/'.$arr_articoli[$cn+1][1].'&$app_id=dbd3886b&$app_key=9ba840248f27670a9bf6d001ae97b3a7';
		echo"\n";
			$response=shell_exec($richiesta);
			echo $response;
			//echo "ctrl ".$a[1]." con ".$arr_articoli[$cn+1][1]."\n";
			echo "c=".(count($arr_articoli)-1)." - cn=".$cn."\n";
			if ($cn<count($arr_articoli)-1)
				$cn=$cn+1;
			else
				break;
		}
	}
}
?>