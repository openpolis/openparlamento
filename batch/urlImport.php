<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'import/votazioni_url.txt';
 
$handle = @fopen($file, "r");
if ($handle)
{
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
  {
    
	$c = new Criteria();
	$c->add(OppVotazionePeer::ID, $data[0], Criteria::EQUAL);
	$votazione = OppVotazionePeer::doSelectOne($c);
	
	if ($votazione == null)
    {
	  echo $data[0].' non trovato '."\n";
    }
	else
	{
	  echo $data[0]."\n";
	  $votazione->setUrl($data[1]);
	  $votazione->save();
	}	
	
  }	
}
else
  print "file non trovato";

print("done.\n");

fclose($handle);
?>