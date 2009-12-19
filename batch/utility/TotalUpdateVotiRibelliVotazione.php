<?php

/*
riscrive tutti i singoli ribelli delle votazioni.
Chiama il file /batch/updateVotiRibelliVotazione.php
Prende in input 
- il numero della legislatura
- il ramo (1 camera, 2 senato) - facoltativo
*/
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c= new Criteria();
$c-> addJoin(OppSedutaPeer::ID,OppVotazionePeer::SEDUTA_ID);
$c-> add(OppSedutaPeer::LEGISLATURA,$argv[1]);
if ($argv[2]==1)
  $c-> add(OppSedutaPeer::RAMO,'C');
if ($argv[2]==2)
  $c-> add(OppSedutaPeer::RAMO,'S');
//$c->setLimit(1000);  

$votazioni = OppVotazionePeer::doSelect($c);

foreach($votazioni as $votazione)
{
  echo shell_exec("php ../updateVotiRibelliVotazione.php ".$votazione->getId());
}

?>  
  