<?php



define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();


$c= new Criteria();
//$c->add(OppAttoPeer::ID, 8333);
$atti=OppAttoPeer::doSelect($c);
foreach ($atti as $atto)
{
	$ctrl=0;
	$fase_iter="ok";
	$c1=new Criteria();
	$c1->addJoin(OppAttoPeer::ID, OppAttoHasIterPeer:: ATTO_ID);
	$c1->addJoin(OppIterPeer::ID, OppAttoHasIterPeer:: ITER_ID);
	$c1->add(OppAttoPeer::ID, $atto->getId());
	$iters=OppAttoHasIterPeer::doSelect($c1);
	foreach ($iters as $iter)
	{
		if ($atto->getStatoCod()=='IC' and ($iter->getOppIter()->getCacheCod()=='CO' || $iter->getOppIter()->getCacheCod()=='RE' || $iter->getOppIter()->getCacheCod()=='AP' ))
		{
			$ctrl=$iter->getOppIter()->getCacheCod();
			$fase_iter=$iter->getOppIter()->getFase();
			$data=$iter->getData();
			break;
		}
		if ($atto->getStatoCod()=='CO' and ($iter->getOppIter()->getCacheCod()=='RE' || $iter->getOppIter()->getCacheCod()=='AP' ))
		{
			$ctrl=$iter->getOppIter()->getCacheCod();
			$fase_iter=$iter->getOppIter()->getFase();
			$data=$iter->getData();
			break;
		}
	}
	if ($fase_iter!="ok")
	{
		echo $atto->getId().";".$atto->getStatoCod().";".$atto->getStatoFase().";'".$atto->getStatoLastDate()."';".$ctrl.";".$fase_iter.";'".$data."'\n";
	}
		
}

?>