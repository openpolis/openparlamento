<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$XY_MAX = 1400;

require_once("batch/get_args_options.php");
$args = arguments($argv);
$argv = $args['input'];
$argc = count($argv);

# controllo sintassi
if ( $argc < 2 ) 
{
  print "sintassi: php batch/transformCoordsToXML C|S [V|F] [NLEG] \n";  
  print "            C|S - (C)amera o (S)enato\n";
  print "            V|F - (V)oti o (F)irme\n";
  print "            NLEG - 15, 16*\n";
  exit;
}

$ramo = $argv[1];
if ($ramo != 'C' && $ramo != 'S')
{
  print "specificare C o S per il ramo (Camera o Senato) \n";  
  exit;  
}


if ($argc == 3)
{
  if ($argv[2] == 'V') $tipo = 'votes';
  elseif ($argv[2] == 'F') $tipo = 'signatures';
  else 
  {
    print "specificare V o F, per il tipo di dati";
  }
}
else
  $tipo = 'votes';

if ($argc == 4)
  $legislatura = $argv[3];
else
  $legislatura = 16;
  
if ($legislatura != 15 && $legislatura != 16)
{
  print "il terzo argomento (legislatura) deve valere 15 o 16 \n";  
  exit;  
}


$xmlstr = <<<XML
<?xml version='1.0' encoding='utf8'?>
<list>
</list>
XML;
$xml = new SimpleXMLElement($xmlstr);

// apertura file delle coordinate octave
$coords_path = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'mds';
$coords_file = $coords_path . DIRECTORY_SEPARATOR . 'opp_'.$tipo.'_'.$legislatura.'_'.$ramo.'.coords';
$fp = fopen($coords_file, "r");
if (!$fp) {
	die ("Impossibile aprire il file $coords_file\n");
}


$coords_content = file($coords_file);

// calcolo minmax globale
$xy_max = 0;
foreach($coords_content as $coords_line){
  // spacchettamento record coordinate
  $line = trim(str_replace("\n", "", $coords_line), " ;");
  list ($cnt, $x, $y, $z, $id_field, $nome_field, $cognome_field, $gruppo_field) = explode(",", $line);
  if (abs($x) > $xy_max) $xy_max = $x;
  if (abs($y) > $xy_max) $xy_max = $y;
}

// produzione XML
foreach($coords_content as $coords_line){

  // spacchettamento record coordinate
  $line = trim(str_replace("\n", "", $coords_line), " ;");
  
  print($line."\n");
  list ($cnt, $x, $y, $z, $id_field, $nome_field, $cognome_field, $gruppo_field) = explode(",", $line);
  list($dummy, $id) = explode(":", $id_field);
  list($dummy, $nome) = explode(":", $nome_field);
  list($dummy, $cognome) = explode(":", $cognome_field);
  list($dummy, $gruppo_id) = explode(":", $gruppo_field);
  
	
	$person_node = $xml->addChild('person');
	$id_node = $person_node->addChild('id',$id);
	$group_node = $person_node->addChild('group',$gruppo_id);
	$name_node = $person_node->addChild('name',$nome);
	$surname_node = $person_node->addChild('surname',$cognome);
	$x_node = $person_node->addChild('x', sprintf('%7.2f', norm($x, $XY_MAX, $xy_max)));
	$y_node = $person_node->addChild('y', sprintf('%7.2f', norm($z, $XY_MAX, $xy_max)));
	printf("%d: (%7.2f, %7.2f) %s %s - %d [%d]\n\n", $cnt, 
	                                           norm($x, $XY_MAX, $xy_max), 
	                                           norm($z, $XY_MAX, $xy_max), 
	                                           $nome, $cognome, $gruppo_id, $id);
}


// apertura file xml in scrittura
$xml_file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'posizioni/opp_'.$tipo.'_'.$legislatura.'_'.$ramo.'.xml';
$xml_fp = fopen($xml_file, "w");
if (!$xml_fp) {
	die ("Impossibile aprire il file $xml_file\n");
}
fwrite($xml_fp, $xml->asXML());
fclose($xml_fp); fclose($fp);


function norm($val, $XY_MAX, $xy_max)
{
  return $XY_MAX + $val * $XY_MAX / $xy_max;
}

?>