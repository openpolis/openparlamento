<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$risultato="";
$cat_tag="";

$c = new Criteria();
$tags = TagPeer::doSelect($c);

foreach($tags as $tag) {


	$c = new Criteria();
	$c->add(TaggingPeer::TAG_ID,$tag->getId());
	$counts = TaggingPeer::doSelect($c);
	$count=count($counts);

	$c = new Criteria();
	$c->addJoin(TagPeer::ID,OppTagHasTtPeer::TAG_ID);
	$c->add(TagPeer::ID,$tag->getId());
	$tts = OppTagHasTtPeer::doSelect($c);

	if (count($tts)>0) {
		$tmp="";
		foreach($tts as $tt) {
			$tmp=$tmp.$tt->getTeseottId().";";
		}
		$tmp=trim($tmp,";");
		$risultato=$risultato.$tag->getId().";".$tag->getTripleValue().";".$tag->getTripleNamespace().";".$count.";".$tmp."\n";
	}
	else
		$risultato=$risultato.$tag->getId().";".$tag->getTripleValue().";".$tag->getTripleNamespace().";".$count."\n";			

}

echo $risultato;
echo "\n --------------------- \n";

$c1 = new Criteria();
$cats = OppTeseottPeer::doSelect($c1);

foreach($cats as $cat) {

	$c2 = new Criteria();
	$c2->addJoin(OppTagHasTtPeer::TAG_ID,TagPeer::ID);
	$c2->add(OppTagHasTtPeer::TESEOTT_ID,$cat->getId());
	$tts = TagPeer::doSelect($c2);
	foreach($tts as $tt) {
		$cat_tag=$cat_tag.$cat->getId().";".$cat->getDenominazione().";".$tt->getId().";".$tt->getTripleValue()."\n";
	}
}

echo $cat_tag;

?>