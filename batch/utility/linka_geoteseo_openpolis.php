<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c= new Criteria();
$c->add(TagPeer::TRIPLE_NAMESPACE,'geoteseo');
$results=TagPeer::doSelect($c);

foreach($results as $result) {

	// controllo se i geoteseo sono nella categoria localita'
	$c1= new Criteria();
	$c1->add(OppTagHasTtPeer::TESEOTT_ID,29);
	$c1->add(OppTagHasTtPeer::TAG_ID,$result->getId());
	$tts=OppTagHasTtPeer::doSelect($c1);
	if (count($tts)==0) {
		$insert= new OppTagHasTt;
		$insert->setTagId($result->getId());
		$insert->setTeseottId(29);
		$ok=$insert->save();
		if ($ok!=1) echo "errore \n";
	}
	/*
	if ($result->getTripleKey()!=0 and $result->getTripleKey()!='tag') {
		echo "kkk \n";
		$tmp1=explode(":",$result->getName());
		$tmp2=explode("=",$result->getName());
		$result->setName($tmp1[0].":0=".$tmp2[1]);
		$result->setTripleKey(0);
		$result->save();
	}
	*/	
	
}

		
	
// controllo se ci sono tag con cat=29 che non sono geoteseo	
$c1= new Criteria();
$c1->addJoin(OppTagHasTtPeer::TAG_ID,TagPeer::ID);
$c1->add(OppTagHasTtPeer::TESEOTT_ID,29);
$c1->add(TagPeer::TRIPLE_NAMESPACE,'geoteseo',Criteria::NOT_EQUAL); 
$tags=TagPeer::doSelect($c1);
foreach ($tags as $tag) {

	$tmp=explode(":",$tag->getName());
	$tmp='geoteseo:'.$tmp[1];
	
	
	$tag->setName($tmp);
	$tag->setTripleNamespace('geoteseo');
	$ok=$tag->save();
	if ($ok!=1) echo "errore \n";
	
}


// metti la provincia tra () e collega id di openpolis

$uri_openpolis="http://www.openpolis.it/locationFindByName/3114a2d106054d26c364c4cfff85910f97f7e29a/";
$testo="";

$c= new Criteria();
$c->add(TagPeer::TRIPLE_KEY,array('tag','0'),Criteria::IN);
$c->add(TagPeer::TRIPLE_NAMESPACE,'geoteseo');
//$c->add(TagPeer::ID,2040);
//$c->setLimit(100);
$results=TagPeer::doSelect($c);

foreach($results as $result) {
	
	$luogo=strtoupper($result->getTripleValue());
	$tipo=0;
	
	if (substr_count(strtoupper($result->getTripleValue()),'REGIONE')>0) {
		$luogo=explode("REGIONE",$luogo);
		$luogo=trim($luogo[1]);
		$tipo=1;
	}	
	if (substr_count(strtoupper($result->getTripleValue()),'PROVINCIA DI')>0) {
		$luogo=explode("PROVINCIA DI",$luogo);
		$luogo=trim($luogo[1]);
		$tipo=2;
	}
	if (substr_count(strtoupper($result->getTripleValue()),'(')>0) {
		$luogo=explode("(",$luogo);
		$luogo=trim($luogo[0]);
		$tipo=3;
	}
	$luogo=utf8_decode($luogo);
	$ok=0;
	
	// richiama api di openpolis
	//echo $uri_openpolis.$luogo."\n";
	//echo "tipo: ".$tipo."\n";
	//echo file_get_contents($uri_openpolis.$luogo);
	$xml = simplexml_load_file($uri_openpolis.$luogo);
	if ($xml) {
		$xml['xmlns'] = '';
		$titoli = $xml->xpath("//locations/location/");
	//	var_dump($titoli);
		$parentesi=1;
		foreach($titoli as $titolo) {
			
			if (strtoupper($titolo)==$luogo && $titolo[type]=='Provincia') $parentesi=0;
		}	
		
		foreach($titoli as $titolo) {
		
			if ($tipo==1) {
				if (strtoupper($titolo)==$luogo && $titolo[type]=='Regione') {
					$tmp1=explode(":",$result->getName());
					$tmp2=explode("=",$result->getName());
					$result->setName($tmp1[0].":".$titolo[id]."=".$tmp2[1]);
					$result->setTripleKey($titolo[id]);
					$result->save();
					$ok=1;
					
				}	
			}
			if ($tipo==2) {
				if (strtoupper($titolo)==$luogo && $titolo[type]=='Provincia') {
					$tmp1=explode(":",$result->getName());
					$tmp2=explode("=",$result->getName());
					$result->setName($tmp1[0].":".$titolo[id]."=".$tmp2[1]);
					$result->setTripleKey($titolo[id]);
					$result->save();
					$ok=1;
				}	
			}
			if ($tipo==3 || $tipo==0 ) {
				//echo strtoupper($titolo)."@".$luogo."\n";
				if (strtoupper($titolo)==$luogo && $titolo[type]=='Comune') {
					$tmp1=explode(":",$result->getName());
					$tmp2=explode("=",$result->getName());
					$result->setTripleKey($titolo[id]);
					if ($tipo==0 && $parentesi==1) {
						$result->setName($tmp1[0].":".$titolo[id]."=".$tmp2[1]." (".$titolo[prov].")");
						$result->setTripleValue($result->getTripleValue()." (".$titolo[prov].")");
						$testo=$testo."case '".$luogo."' : \n id_del_tag='".$result->getId()."'; \n break; \n";
					}
					else
						$result->setName($tmp1[0].":".$titolo[id]."=".$tmp2[1]);
								
					$result->save();
					$ok=1;
				}
				
			}		
		}	
	}
	else {
		echo "problemi con pagina ".$luogo."\n";
		
	}	
	
if ($ok==0) {
	echo "non trovo id=".$result->getId()." ".$luogo."\n";
//	echo $uri_openpolis.$luogo." \n ---- \n";
}	

}
echo $testo;

?>
