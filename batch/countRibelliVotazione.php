<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("start script.\n");  


if ($argv[1])
{
  print "elaborazione votazione: " . $argv[1] . "...\n";
  $c = new Criteria();
  $c->add(OppVotazionePeer::ID, $argv[1], Criteria::EQUAL);
  $votazione = OppVotazionePeer::doSelectOne($c);
  
  $count = $votazione->getRibelliCount();	
  
  $votazione->setRibelli($count);
  $votazione->save();	
	
}
else
  print "identificativo votazione non inserito";

print("done.\n");  	

?>