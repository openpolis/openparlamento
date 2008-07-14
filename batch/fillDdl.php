<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$ddls = OppDdlPeer::doSelect(new Criteria());

foreach($ddls as $ddl)
{
    
  $atto = new OppAtto;
  $atto->setId($ddl->getId());
  $atto->setParlamentoId($ddl->getParlamentoId());
  $atto->setTipoAttoId($ddl->getTipo());
  $atto->setRamo($ddl->getRamo());
  $atto->setNumfase($ddl->getNumfase());
  $atto->setLegislatura($ddl->getLegislatura());
  $atto->setDataPres($ddl->getDataPres());
  $atto->setDataAgg($ddl->getDataAgg());
  $atto->setTitolo($ddl->getTitolo());
  $atto->setIniziativa($ddl->getIniziativa());
  $atto->setCompleto($ddl->getCompleto());
  $atto->setDescrizione($ddl->getDescrizione());
  $atto->setSeduta($ddl->getSeduta());
  $atto->setIter($ddl->getIter());
  $atto->setDataIter($ddl->getDataIter());
  
  $atto->save();
  print "atto: " . $atto->getId() . "...\n"; 
}

print("done.\n");

?>