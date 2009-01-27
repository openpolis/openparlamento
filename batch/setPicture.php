<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$c = new Criteria();
$parlamentare = OppPoliticoPeer::retrieveByPk(4);

$xml = simplexml_load_file('http://openpolis.depplab.net/api/politician/id/4');
$picture = $xml->politician->image;
$parlamentare->setPicture($picture);
$parlamentare->save();


/*	
foreach ($parlamentari as $parlamentare)
{
  $xml = simplexml_load_file('http://www.openpolis.it/api/politician/id/'.$parlamentare->getOpId());
  $nome = $xml->politician->firstname;
  $cognome = $xml->politician->lastname;
  $politico = new OppPolitico();
  $politico->setId($parlamentare->getOpId());
  $politico->setNome($nome);
  $politico->setCognome($cognome);
  $politico->save();
  echo "$nome $cognome\n";
}
*/

print("done.\n");

?>