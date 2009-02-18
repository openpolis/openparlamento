<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("start script.\n");  

  $c = new Criteria();
  $c->addJoin(OppVotazionePeer::SEDUTA_ID,OppSedutaPeer::ID);
  $c->add(OppSedutaPeer::LEGISLATURA, 16, Criteria::EQUAL);
  $votazioni = OppVotazionePeer::doSelect($c);
  
  foreach ($votazioni as $votazione) {
     $count = $votazione->getRibelliCount();
     
     $votazione->setRibelli($count);
     $ok=$votazione->save();
     
     if ($ok==1) echo "si - ";
     else echo "no \n";
     
   }   	
	


?>
