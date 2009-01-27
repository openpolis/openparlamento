<?php
 
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();
 
$c = new Criteria();
$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
$c->add(OppCaricaPeer::LEGISLATURA, 16);
//$c->Limit(1);
$rss = OppPoliticoPeer::doSelect($c);

foreach ($rss as $rs) {

$newfile="foto/".$rs->getId();
$dl="http://openpolis.depplab.net/politician/picture?content_id=".$rs->getId();
copy($dl,$newfile);
	
}

?>