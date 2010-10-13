<?php

/*
Lo script controlla le cariche all'inteno della camera dei deputati
- Prende in input numero della legislatura

*/

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false); 
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c= new Criteria();
$c->addJoin(OppCaricaPeer::POLITICO_ID,OppPoliticoPeer::ID);
$c->add(OppCaricaPeer::LEGISLATURA,$argv[1]);
$c->add(OppCaricaPeer::TIPO_CARICA_ID,1);
$c->addAscendingOrderByColumn(OppPoliticoPeer::COGNOME);
$results=OppcaricaPeer::doSelect($c);
foreach($results as $result)
{
  echo shell_exec("php 02_aggiorna_carica_camera_da_pagina_deputato.php ".$result->getId());
}


?>