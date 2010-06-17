<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

/**
 * Lo script prepara la normaliazzione dei tag di openparlamento
 *
 */
 
 // estraggo tutti i tag di opp con il numero di atti (no emendamenti) associati
$tagToDdl=TaggingPeer::CountTagForAtti('OppAtto');
$tagToEm=TaggingPeer::CountTagForAtti('OppEmedamento');

$tagToAll=array();
foreach ($tagToDdl as $key => $value) {
  if (array_key_exists($key,$tagToEm)) {
    $tagToAll[$key]=array($value[0],$value[1], $tagToEm[$key][1]);
  }
  else {
    $tagToAll[$key]=array($value[0],$value[1], 0);
  }
}

foreach ($tagToEm as $key => $value) {
  if (!array_key_exists($key,$tagToAll)) {
    $tagToAll[$key]=array($value[0],0,$value[1]);
  }
}

foreach ($tagToAll as $key => $value) {
  echo $key."\t".$value[0]."\t".$value[1]."\t".$value[2]."\n";
}
 


?>