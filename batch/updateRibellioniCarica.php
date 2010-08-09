<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'task');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n\n");

$legislatura_corrente = OppLegislaturaPeer::getCurrent();
$data = date('Y-m-d');
$parlamentari_rs = OppCaricaPeer::getParlamentariRamoDataRS('parlamento', $legislatura_corrente, $data);    

while ($parlamentari_rs->next()) 
{
  $p = $parlamentari_rs->getRow();
  $carica_id = $p['id'];
  $gruppo = OppCaricaPeer::getGruppo($carica_id, $data);
  $gruppo_id = $gruppo['id'];
  $gruppo_obj = OppCaricaHasGruppoPeer::retrieveByPK($carica_id, $gruppo_id);
  if (is_null($gruppo_obj)) 
  {
    printf("WARNING: NESSUN RECORD: carica: %d, gruppo: %d\n", $carica_id, $gruppo_id);     
    continue; 
  }
  $n_ribellioni = OppVotazioneHasCaricaPeer::countRibellioniCaricaData($p['id'], $legislatura_corrente, $data, $gruppo_obj->getDataInizio());
  $gruppo_obj->setRibelle($n_ribellioni);
  $gruppo_obj->save();
  printf("carica: %d, gruppo: %d, n_ribellioni: %d\n", $carica_id, $gruppo_id, $n_ribellioni);  
}

// mail("e.dicesare@depp.it", "OK - Update Ribellioni", "aggiornamento a buon fine", "From: BatchOpp");	

?>
