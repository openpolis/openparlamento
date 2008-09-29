<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

print("start script.\n");  	

print("SELECT.\n");  	
$c = new Criteria();

$c->add(OppAttoPeer::TITOLO, '0/%', Criteria::LIKE);
$c->add(OppAttoPeer::ID, 14500, Criteria::GREATER_THAN);

$c->setLimit(10);
$c->addAscendingOrderByColumn(OppAttoPeer::TITOLO);
$rss = OppAttoPeer::doSelect($c);

foreach ($rss as $rs) {
  echo $rs->getId() . ") " . $rs->getTitolo() . "\n";
}

unset($c);



print("JOIN.\n");  	
$c = new Criteria();
$c->addJoin(OppAttoPeer::ID, OppAttoHasTeseoPeer::ATTO_ID);
$c->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID);
$c->add(OppTeseoPeer::DENOMINAZIONE, 'mo%', Criteria::LIKE);

$atti = OppAttoPeer::doSelect($c);
echo "N: " . count($atti) . "\n";

foreach ($atti as $atto) {
  
  $tags = $atto->getOppAttoHasTeseos();
  echo $atto->getId() . " (". count($tags) .") " . $atto->getTitolo() . "\n";
  
  echo "  tags: ";
  foreach ($tags as $tag) {
    echo $tag->getOppTeseo()->getDenominazione() . ", ";
  }
  echo "\n";
  
}



/*
print ("INSERT\n");
foreach (array('utenti', 'geo', 'teseo') as $t) {
  $tipo = new OppTipoTeseo();
  $tipo->setTipo($t);
  $tipo->save();
  $last_id = $tipo->getId();
}
*/


print ("UPDATE\n");
$c = new Criteria();
$c->add(OppTipoTeseoPeer::TIPO, 'old_user');
$tipo = OppTipoTeseoPeer::doSelectOne($c);
$tipo->setTipo('user');
$affected_rows = $tipo->save();

echo "affected: " . $affected_rows . "\n";

print("done.\n");  	

?>