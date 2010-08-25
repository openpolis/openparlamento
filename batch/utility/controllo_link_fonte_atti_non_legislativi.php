<?php

/*
Controlla i link rotti nelle fonti degli atti non legislativi
In input:
- il numero della legislatura

*/

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c= new Criteria();
$c->add(OppAttoPeer::TIPO_ATTO_ID,array(2,3,4,5,6,7,8,9,10,11), Criteria::IN);
$c->addDescendingOrderByColumn(OppAttoPeer::CREATED_AT);
$attos=OppAttoPeer::doSelect($c);
foreach ($attos as $atto)
{
  $testo=shell_exec("curl -L http://banchedati.camera.it/sindacatoispettivo_".$argv[1]."/showXhtml.Asp?idAtto=".$atto->getParlamentoId());
  if (substr_count($testo,'Errore nella esecuzione della query')>0)
   echo "no link per id=".$atto->getId()." numfase=".$atto->getRamo().".".$atto->getNumfase()."\n";
}



?>