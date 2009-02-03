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

require_once("batch/get_args_options.php");
$args = arguments($argv);
$argv = $args['input'];
$argc = count($argv);


# controllo sintassi
if ( $argc < 2 ) 
{
  print "sintassi: php batch/updateMPSDistanceForVotes \$ramo [\$legislatura] \n";  
  print "            \$ramo        - (C)amera o (S)enato\n";
  print "            \$legislatura - 15, 16\n";
  exit;
}

$ramo = $argv[1];
if ($ramo != 'C' && $ramo != 'S')
{
  print "specificare C o S per il ramo (Camera o Senato) \n";  
  exit;  
}

if ($argc == 3)
  $legislatura = $argv[2];
else
  $legislatura = 16;
if ($legislatura != 15 && $legislatura != 16)
{
  print "il secondo argomento (legislatura) deve valere 15 o 16 \n";  
  exit;  
}

$voto['Favorevole'] = 'FAV';
$voto['Contrario'] = 'CON';
$voto['Astenuto'] = 'AST';
$voto['Assente'] = 'NA';
$voto['In missione'] = 'NA';
$voto['Presidente di turno'] = 'NA';
$voto['Richiedente la votazione e non votante'] = 'NA';
$voto['Voto segreto'] = 'SKIP';
$voto['Partecipante votazione non valida'] = 'SKIP';


// estrae le cariche (attuali) per ramo e legislatura
$c = new Criteria();
$c->add(OppCaricaPeer::LEGISLATURA, $legislatura);
$c->add(OppCaricaPeer::DATA_FINE, null, Criteria::ISNULL);
if ($ramo == 'C')
  $c->add(OppCaricaPeer::TIPO_CARICA_ID, 1);
else
  $c->add(OppCaricaPeer::TIPO_CARICA_ID, array(4, 5), Criteria::IN);

$cariche = OppCaricaPeer::doSelect($c);
unset($c);


$ncariche = count($cariche);
echo $ncariche . "\n";

// costruisce array dei politici, con i voti
$politici = array();
foreach ($cariche as $i => $carica) {
  $politico = $carica->getOppPolitico();
  $politici[$i]['id'] = $carica->getId(); 
  $politici[$i]['cognome'] = $politico->getCognome(); 
  $politici[$i]['nome'] = $politico->getNome(); 
  echo $i . ": " . $politici[$i]['nome'] . " " . $politici[$i]['cognome'] . ": ";
  
  // legge i voti dal DB e li mette nell'array voti
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
    $v = $voto[$res->getString(2)];
    if ($v != 'NA' && $v != 'SKIP')
      $voti[$res->getInt(1)] = $v;
  }  
  $politici[$i]['voti'] = $voti;
  unset($res);
  $nvoti = count($voti);
  
  // legge le firme dal DB e li mette nell'array firme
  $c = new Criteria();
  $c->clearSelectColumns();
  $c->addSelectColumn(OppCaricaHasAttoPeer::ATTO_ID);
  $c->addSelectColumn(OppCaricaHasAttoPeer::TIPO);
  $c->add(OppCaricaHasAttoPeer::CARICA_ID, $carica->getId());
  $res = OppCaricaHasAttoPeer::doSelectRS($c);

  $firme = array();
  while ($res->next())
  {
    $firme[$res->getInt(1)] = $res->getString(2);
  }  
  $politici[$i]['firme'] = $firme;
  unset($res);
  $nfirme = count($firme);

  echo " ($nvoti voti, $nfirme firme)\n";

}

// rimozione dati precedenti
OppSimilaritaPeer::doDeleteAll();

// scrittura completa della matrice simmetrica delle similarità
for ($i = 0; $i<$ncariche; $i++)
{
  $dd = new OppSimilarita();
  $dd->setCaricaFromId($politici[$i]['id']);
  $dd->setCaricaToId($politici[$i]['id']);
  $dd->setVotingSimilarity(0);
  $dd->setSigningSimilarity(0);
  $dd->save();
  $dd = null;
  unset($dd);
  
  for ($j = $i+1; $j<$ncariche; $j++)
  {
    $d = new OppSimilarita();
    $d->setCaricaFromId($politici[$i]['id']);
    $d->setCaricaToId($politici[$j]['id']);
    $d->setVotingSimilarity(similarityForVotes($politici[$i], $politici[$j], $ramo) / $ncariche);
    $d->setSigningSimilarity(similarityForSignatures($politici[$i], $politici[$j]) / $ncariche);
    $d->save();
    
    // scrittura elemento simmetrico
    $ds = new OppSimilarita();
    $ds->setCaricaFromId($d->getCaricaToId());
    $ds->setCaricaToId($d->getCaricaFromId());
    $ds->setVotingSimilarity($d->getVotingSimilarity());
    $ds->setSigningSimilarity($d->getSigningSimilarity());
    $ds->save();
  
    $ds = null;
    unset($ds);
  
    $d = null;
    unset($d);
  }
  print ".";
  if ($i > 0 && $i % 10 == 0) print "$i/$ncariche ";
  if ($i > 0 && $i % 50 == 0) print "\n";
}

echo "done\n";



/**
 *  Funzione che calcola la distanza tra due politici, per quanto riguarda i voti
 *  come trasformazione monotòna decrescente (exp(-x)) di un fattore di similarità
 *  il fattore di similarità è la somma delle similarità tra voti:
 *  Stesso voto:  
 *  CON - FAV  : -5
 *  AST - FAV  : 2C | -4S
 *  AST - CON  : 2C |  4S
 *  Assenza o invalidità: 0  
 */
function similarityForVotes($p1, $p2, $ramo){

	$sim = 0;
	foreach ($p1['voti'] as $id => $value){
	  if (!array_key_exists($id, $p2['voti']))
	    $s = 0;
	  elseif ($p1['voti'][$id] == $p2['voti'][$id]) $s = 6;
	  elseif ($p1['voti'][$id] == 'CON' && $p2['voti'][$id] == 'FAV' || 
	          $p2['voti'][$id] == 'CON' && $p1['voti'][$id] == 'FAV') $s = -6;
	  elseif ($p1['voti'][$id] == 'AST' && $p2['voti'][$id] == 'FAV' || 
	          $p1['voti'][$id] == 'FAV' && $p2['voti'][$id] == 'AST') $s = ($ramo=='C')?2:-4;
	  elseif ($p1['voti'][$id] == 'AST' && $p2['voti'][$id] == 'CON' || 
	          $p1['voti'][$id] == 'CON' && $p2['voti'][$id] == 'AST') $s = ($ramo=='C')?2:4;
	  else $s = 0;
	  
		$sim += $s;
	}	
	return $sim;
}



/**
 *  Funzione che calcola la distanza tra due politici, per quanto riguarda le firme
 *  come trasformazione monotòna decrescente (exp(-x)) di un fattore di similarità
 *  il fattore di similarità è la somma delle similarità per le singole firme:
 *  P - P  : 6
 *  P - R  : 6
 *  R - R  : 6
 *  P - C  : 3
 *  R - C  : 3
 *  C - C  : 1
 *  * - -  : 0
 */
function similarityForSignatures($p1, $p2){

	$sim = 0;
	foreach ($p1['firme'] as $id => $value){
	  if (!array_key_exists($id, $p2['firme']))
	    $s = 0;
	  elseif ($p1['firme'][$id] == 'P' && $p2['firme'][$id] == 'P')  $s = 6;
	  elseif ($p1['firme'][$id] == 'P' && $p2['firme'][$id] == 'R' || 
	          $p1['firme'][$id] == 'R' && $p2['firme'][$id] == 'P') $s = 6;
	  elseif ($p1['firme'][$id] == 'R' && $p2['firme'][$id] == 'R') $s = 6;
	  elseif ($p1['firme'][$id] == 'P' && $p2['firme'][$id] == 'C' || 
	          $p1['firme'][$id] == 'C' && $p2['firme'][$id] == 'P') $s = 3;
	  elseif ($p1['firme'][$id] == 'R' && $p2['firme'][$id] == 'C' || 
	          $p1['firme'][$id] == 'C' && $p2['firme'][$id] == 'R') $s = 3;
	  elseif ($p1['firme'][$id] == 'C' && $p2['firme'][$id] == 'C') $s = 1;
	  else $s = 0;
	  
		$sim += $s;
	}
	return $sim;
}
