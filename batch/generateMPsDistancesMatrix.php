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
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$legislatura = 16;
$ramo = 'C';

$voto['Favorevole'] = 'FAV';
$voto['Contrario'] = 'CON';
$voto['Astenuto'] = 'AST';
$voto['Assente'] = 'NA';
$voto['In missione'] = 'NA';
$voto['Presidente di turno'] = 'NA';
$voto['Richiedente la votazione e non votante'] = 'NA';
$voto['Voto segreto'] = 'SKIP';
$voto['Partecipante votazione non valida'] = 'SKIP';


$c = new Criteria();
$c->add(OppCaricaPeer::LEGISLATURA, $legislatura);
$c->add(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL);
if ($ramo == 'C')
  $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
else
  $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4, 5), Criteria::IN);

$c->setLimit(625);

$cariche = OppCaricaPeer::doSelect($c);
unset($c);

$npolitici = count($cariche);
echo $npolitici . "\n";
$politici = array();
foreach ($cariche as $i => $carica) {
  $politico = $carica->getOppPolitico();
  $politici[$i]['id'] = $politico->getId(); 
  $politici[$i]['cognome'] = $politico->getCognome(); 
  $politici[$i]['nome'] = $politico->getNome(); 
  echo $i+1 . ": " . $politici[$i]['nome'] . " " . $politici[$i]['cognome'] . ": ";
  
  $c = new Criteria();
  $c->add(OppCaricaHasGruppoPeer::DATA_FINE, null, Criteria::ISNULL);
  $gruppi = $carica->getOppCaricaHasGrupposJoinOppGruppo($c);
  $gruppo = $gruppi[0]->getOppGruppo();
  $politici[$i]['gruppo']['id'] = $gruppo->getId();
  $politici[$i]['gruppo']['sigla'] = $gruppo->getAcronimo();
  
  $c = new Criteria();
  $c->clearSelectColumns();
  $c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTAZIONE_ID);
  $c->addSelectColumn(OppVotazioneHasCaricaPeer::VOTO);
  $c->add(OppVotazioneHasCaricaPeer::CARICA_ID, $carica->getId());
  $c->addJoin(OppVotazionePeer::ID, OppVotazioneHasCaricaPeer::VOTAZIONE_ID);
  $res = OppVotazioneHasCaricaPeer::doSelectRS($c);

  $voti = array();
  while ($res->next())
  {
    $voti[$res->getInt(1)] = $voto[$res->getString(2)];
  }  
  $politici[$i]['voti'] = $voti;
  // print_r($politici[$i]);
  unset($res);
  $nvoti = count($voti);
  echo "($nvoti)\n";
}

// apertura e scrittura nel file
try {
	$tmp = tempnam("/var/tmp", "opp_mds_");
	$fp = fopen($tmp, "w");
	if (!$fp) {
		die ("Impossibile aprire il file $tmp\n");
	}

	// generazione della matrice di dissimilarità nel file temporaneo
	// che sarà invocato da octave
	for ($i=0; $i<$npolitici; $i++){

    $politico = $politici[$i];
    
		// stampa riga con id politico, nome e gruppo
		printf("p%d = \"%d: %s %s (%s);\"\n", 
		       $i+1, $politico['id'], $politico['nome'], $politico['cognome'], $politico['gruppo']['sigla']);
		fprintf($fp, "p%d = \"%d: %s %s (%s);\"\n", 
		        $i+1, $politico['id'], $politico['nome'], $politico['cognome'], $politico['gruppo']['sigla']);

		// stampa riga con valori matrice dissimilarità
		fprintf($fp, "r%d = [ ", $i+1);
		for ($j=0; $j<$npolitici; $j++){
			fprintf($fp, "%5.3f", eDist($politici[$i], $politici[$j]));
			if ($j<$npolitici-1) {
				fprintf($fp, ", ");
			}
		}
		fprintf($fp, " ];\n");
	}

	// ultime due righe per aggregare i dati precedenti
	fprintf($fp, "ps = [");
	for ($i=0; $i<$npolitici; $i++){
		fprintf($fp, "p%d; ", $i+1);
	}
	fprintf($fp, "];\n");

	fprintf($fp, "D = [");
	for ($i=0; $i<$npolitici; $i++){
		fprintf($fp, "r%d; ", $i+1);
	}
	fprintf($fp, "];\n");

	$tmp_coords = $tmp . ".coords";
	fprintf($fp, "coords_file=\"%s\";\n", $tmp_coords);

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



/**
 *  Funzione che calcola la distanza tra due politico
 *  come distanza euclidea nello spazio delle coordinate dei voti
 *  la distanza tra i voti è:
 *  Stesso voto: 0
 *  CON - FAV  : 4
 *  AST - FAV  : 2 | 3
 *  AST - CON  : 2 | 1
 *  NA         : 0 con tutti
 *  
 */
function eDist($p1, $p2){

	$dist = 0;
	foreach ($p1['voti'] as $id => $value){
	  if (!array_key_exists($id, $p2['voti']))
	    $d = 0;
	  elseif ($p1['voti'][$id] == 'CON' && $p2['voti'][$id] == 'FAV' || 
	      $p2['voti'][$id] == 'CON' && $p1['voti'][$id] == 'FAV') $d = 4;
	  elseif ($p1['voti'][$id] == 'AST' && $p2['voti'][$id] == 'FAV' || 
	          $p1['voti'][$id] == 'AST' && $p2['voti'][$id] == 'FAV') $d = 2;
	  elseif ($p1['voti'][$id] == 'AST' && $p2['voti'][$id] == 'CON' || 
	          $p1['voti'][$id] == 'AST' && $p2['voti'][$id] == 'CON') $d = 2;
	  else $d = 0;
	  
		$dist += $d * $d;
	}
	return $dist;
}
