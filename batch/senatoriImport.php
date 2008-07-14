<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$xml = simplexml_load_file('http://www.openpolis.it/api/senatori');

foreach ($xml->charges->charge as $charge)
{
  
  $politico = OppPoliticoPeer::RetrieveByPk($charge->politicianid);
  if ($politico == null)
  {
    $xml = simplexml_load_file('http://www.openpolis.it/api/politician/id/'.$charge->politicianid);
    $nome = $xml->politician->firstname;
    $cognome = $xml->politician->lastname;
    
    echo "$nome $cognome \n";
    
    $politico = new OppPolitico();
    $politico->setId($charge->politicianid);
    $politico->setNome($nome);
    $politico->setCognome($cognome);
    $politico->save();
    
  }
  
  $carica = new OppCarica();
  $carica->setId($charge->id);
  $carica->setPoliticoId($charge->politicianid);
  $carica->setCarica($charge->chargetype);
  $carica->setDataInizio($charge->datestart);
  $carica->setGruppo($charge->group);
  $carica->setLegislatura(16);
  $carica->setCircoscrizione($charge->constituency);  
  $carica->save();
  echo "$charge->id\n";
  
  
}

print("done.\n");

?>