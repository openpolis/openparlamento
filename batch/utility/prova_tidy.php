<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$config=array("doctype"=> 'auto',
"add-xml-decl"=> false,
"add-xml-space"=> false,
"assume-xml-procins"=> false,
"bare"=> false,
"break-before-br"=> false,
"clean"=> false,
"drop-empty-paras"=> true,
"drop-font-tags"=> false,
"drop-proprietary-attributes"=> false,
"enclose-block-text"=> false,
"enclose-text"=> false,
"escape-cdata"=> false,
"fix-bad-comments"=> true,
"fix-uri"=> true,
"hide-comments"=> false,
"hide-endtags"=> false,
"indent-cdata"=> false,
"input-xml"=> false,
"join-classes"=> false,
"join-styles"=> true,
"logical-emphasis"=> false,
"lower-literals"=> true,
"ncr"=> true,
"numeric-entities"=> false,
"output-xhtml"=> true,
"output-xml"=> false,
"quote-ampersand"=> true,
"quote-marks"=> false,
"quote-nbsp"=> true,
"repeated-attributes"=> true,
"replace-color"=> false,
"show-body-only"=> true,
"uppercase-attributes"=> false,
"uppercase-tags"=> false,
"word-2000"=> true,
"indent"=> false,
"indent-attributes"=> false,
"literal-attributes"=> false,
"markup"=> true,
"wrap-asp"=> false,
"wrap-attributes"=> false,
"wrap-jste"=> true,
"wrap-php"=> true,
"wrap-script-literals"=> false,
"wrap-sections"=> true,
"wrap"=> 0,
"new-empty-tags"=>'cfelse',
"ascii-chars"=> false);


$c= new Criteria();
//$c->add(OppDocumentoPeer::ID,1149);
//$c->setLimit(10);
$results=OppDocumentoPeer::doSelect($c);

foreach($results as $result)
{
echo $result->getId()."\n";
$testo=$result->getTesto();
//echo $testo;

$chr_encoding = mb_detect_encoding($testo,'ASCII,ISO-8859-1,WINDOWS-1252,UTF-8');
echo  "*********************".$chr_encoding."******************************** \n";
switch ($chr_encoding) {
	case 'UTF-8':
	   $tidy_enc = 'utf8';
	break;
	case 'ASCII':
	   $tidy_enc = 'ascii';
	break;
	case 'WINDOWS-1252':
	   $tidy_enc = 'win1252';
	break;
	case 'ISO-8859-1':
	   $tidy_enc = 'latin1';
	break;
}
	
$tidy = tidy_parse_string($testo,$config,$tidy_enc);
if( tidy_warning_count($tidy)>0) {
	echo "warning first: " .tidy_warning_count($tidy) ."\n";
        //echo $tidy->errorBuffer."\n";
	$tidy1=tidy_repair_string($testo,$config,"utf8");
	$tidy2 = tidy_parse_string($tidy1,$config,"utf8");
  //      echo $tidy1;
	echo "warning last: ".tidy_warning_count($tidy2). "\n";
	echo $tidy2->errorBuffer."\n";
	//echo $result->getId()."\n-----------------------------------\n";
	//echo $tidy1;
        try {
          $result->setTesto((string)$tidy1);
	  $result->save();
	} catch (Exception $e){
	  echo "Errore: " . $e->getMessage()."\n";
	}
}

//echo $tidy->errorBuffer;
echo "\n-----------------------------------------------------------------------------\n";
}
?>

