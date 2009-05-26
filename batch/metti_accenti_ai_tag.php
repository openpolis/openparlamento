<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$tag_ok="Treno Alta Velocità (TAV)";
$tag_ok=utf8_encode($tag_ok);

$tag_no="Treno Alta Velocit";

$c = new Criteria();
//$c->add(TagPeer::ID, 284);
$c->add(TagPeer::TRIPLE_VALUE, $tag_no);
$rs = TagPeer::doSelectOne($c);
if ($rs) {
	$rs->setTripleValue($tag_ok);
	$namespace=explode("=",$rs->getName());
	$rs->setName($namespace[0]."=".$tag_ok);
	$ok=$rs->save();
	if ($ok==1) echo "ok \n";
	else echo "no \n";
}
else echo "non trovo tag ".$tag_no."\n";

?>	
