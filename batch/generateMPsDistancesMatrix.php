<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2009 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Generates the matrix of distances between MPs
 *
 */
?>
<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

require_once("batch/get_args_options.php");
$args = arguments($argv);
$argv = $args['input'];
$argc = count($argv);

# controllo sintassi
if ( $argc < 2 ) 
{
  print "sintassi: php batch/generateMPsDistancesMatrixForVotes C|S [NLEG]\n";  
  print "            C|S - (C)amera o (S)enato\n";
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


try {
  // apertura file temporaneo contenente matrice di dissimilarità
  $tmp_path = DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'tmp';
	$tmp = tempnam("/var/tmp", "opp_mds_");
	$fp = fopen($tmp, "w");
	if (!$fp) {
		die ("Impossibile aprire il file $tmp\n");
	}



	// generazione della matrice di dissimilarità nel file temporaneo
	// che sarà invocato da octave

  // estrae le cariche (attuali) per ramo e legislatura
  $c = new Criteria();
  $c->add(OppCaricaPeer::LEGISLATURA, $legislatura);
  $c->add(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL);
  if ($ramo == 'C')
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
  else
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4, 5), Criteria::IN);
  // $c->setLimit(20);
  $cariche = OppCaricaPeer::doSelect($c);
  unset($c);

  $ncariche = count($cariche);
  echo $ncariche . "\n";

  foreach ($cariche as $i => $carica_i) {

    $politico_i = $carica_i->getOppPolitico();
    $gruppo_id = $politico_i->getGruppoCorrente()->getId();
    
		// stampa riga con id politico, nome e gruppo
		$pol_descr = sprintf("p%d = \"id:%d,nome:%s,cognome:%s,gruppo_id:%d;\"\n", 
		                     $i+1, $politico_i->getId(), 
		                     $politico_i->getNome(), $politico_i->getCognome(), $gruppo_id);
		print($pol_descr);
		fwrite($fp, $pol_descr);

		// stampa riga con valori matrice distanze
		// dist = MAX - sim
		fprintf($fp, "r%d = [ ", $i+1);
		foreach ($cariche as $j => $carica_j){
      $d = OppSimilaritaPeer::retrieveByPK($carica_i->getId(), $carica_j->getId());

      if ($tipo == 'votes')
        $dist = OppSimilaritaPeer::getMaxSimilarityForVotes() - $d->getVotingSimilarity();
      else
        $dist = OppSimilaritaPeer::getMaxSimilarityForSignatures() - $d->getSigningSimilarity();
      
			fprintf($fp, "%5.3f", $dist);
			if ($j<$ncariche-1) {
				fprintf($fp, ", ");
			}
		}
		fprintf($fp, " ];\n");
	}

	// ultime due righe per aggregare i dati precedenti
	fprintf($fp, "ps = [");
	for ($i=0; $i<$ncariche; $i++){
		fprintf($fp, "p%d; ", $i+1);
	}
	fprintf($fp, "];\n");

	fprintf($fp, "D = [");
	for ($i=0; $i<$ncariche; $i++){
		fprintf($fp, "r%d; ", $i+1);
	}
	fprintf($fp, "];\n");

  $coords_path = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'mds';
	$coords_file = $coords_path.DIRECTORY_SEPARATOR.'opp_'.$tipo.'_'.$legislatura.'_'.$ramo.".coords";
	fprintf($fp, "coords_file=\"%s\";\n", $coords_file);

	// copio il template mds_template.m nel file temporaneo
	$mds_template_file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'batch'.DIRECTORY_SEPARATOR.'mds_template.m';
	$mds_content = file($mds_template_file);
	fprintf($fp, "\n\n# ------ mds_template content ------\n");
	foreach($mds_content as $line){
		fprintf($fp, "%s", $line);
	}

	fclose($fp);

  

	// invocazione di octave (exec è sincrono)
	// che produce il file di coordinate
	$octave = sfConfig::get('sf_octave_cmd', '/usr/local/bin/octave');
	exec("$octave $tmp");
	

} catch (Exception $e) {
  printf("Errore: %s", $e->getMessage());
}
