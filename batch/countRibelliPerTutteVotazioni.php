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
	
   $c = new Criteria();
   $c-> add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID,$votazione->getId());
   $c-> add(OppVotazioneHasCaricaPeer::RIBELLE,1);
   $count= OppVotazioneHasCaricaPeer::doCount($c);
   $votazione->setRibelli($count);
   $votazione->save();
 }


?>
