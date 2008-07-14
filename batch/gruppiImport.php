<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$xml = simplexml_load_file('http://www.openpolis.it/api/gruppi');

foreach ($xml->gruppi->gruppo as $gruppo)
{
  
  $gruppo_esistente = OppGruppoPeer::RetrieveByPk($gruppo->id);
  if ($gruppo_esistente == null)
  {
    $gruppo_nuovo = new OppGruppo();
    $gruppo_nuovo->setId($gruppo->id);
    $gruppo_nuovo->setNome($gruppo->nome);
    $gruppo_nuovo->setAcronimo($gruppo->acronimo);
    $gruppo_nuovo->save();
    
    echo "inserito $gruppo->nome\n";
  }
  else
  {
    echo "$gruppo->nome gia esistente\n";
  }
  
}

print("done.\n");

?>