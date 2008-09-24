<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("Fetching data... \n");

$c = new Criteria();
$cariche = OppCaricaPeer::doSelect($c);


foreach($cariche as $carica)
{
  print $carica->getId(). "...\n";	
  $c = new Criteria();
  $c->add(OppCaricaPeer::ID, $carica->getId(), Criteria::EQUAL);
  $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1, Criteria::EQUAL);
  $mycarica = OppCaricaPeer::doSelectOne($c);
  
  switch($mycarica->getCarica())
  {
    case 'Deputato';
      $mycarica->setTipoCaricaId(1);
      break;
    case 'Ministro';
      $mycarica->setTipoCaricaId(2);
      break;
	case 'Presidente';
      $mycarica->setTipoCaricaId(3);
      break;
	case 'Senatore';
      $mycarica->setTipoCaricaId(4);
      break;
    case 'Senatore a vita';
      $mycarica->setTipoCaricaId(5);
      break;
    case 'Sottosegretario';
      $mycarica->setTipoCaricaId(6);
      break;
  }
  
  $mycarica->save();
  	
  //print "carica: " . $mycarica->getCarica() . " id tipo carica: " . $mycarica->getTipoCaricaId() . "...\n";
  
}

print("done.\n");

?>