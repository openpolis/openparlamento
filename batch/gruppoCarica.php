<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$cariche = OppCaricaPeer::doSelect(new Criteria());
	
foreach ($cariche as $carica)
{
  $c = new Criteria();
  $c->add(OppGruppoPeer::NOME, $carica->getGruppo(), Criteria::EQUAL);
  $gruppo = OppGruppoPeer::doSelectOne($c);
  if ($gruppo != null)
  {
    $carica_gruppo = new OppCaricaHasGruppo;
    $carica_gruppo->setCaricaId($carica->getId());
    $carica_gruppo->setGruppoId($gruppo->getId());
    $carica_gruppo->setDataInizio($carica->getDataInizio());
    $carica_gruppo->setDataFine($carica->getDataFine());
    $carica_gruppo->save();
  }
  else
    echo "carica $carica->getId() gruppo non trovato\n";
}

print("done.\n");

?>