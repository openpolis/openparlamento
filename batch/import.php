<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'import/new.txt';
 
$handle = @fopen($file, "r");
if ($handle)
{
  while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
  {
    $parlamentare_has_votazione = new OppVotazioneHasPolitico;
	  $parlamentare_has_votazione->setVotazioneId($data[0]);
	  $parlamentare_has_votazione->setPoliticoId($data[1]);
	  $parlamentare_has_votazione->setVoto($data[2]);
    $parlamentare_has_votazione->save();
      
    echo $data[0].' '.$data[1].' '.$data[2]."\n";
	}	
}
else
  print "file non trovato";

print("done.\n");

fclose($handle);
?>