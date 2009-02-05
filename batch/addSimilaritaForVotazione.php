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
  print "sintassi: php batch/updateMPSDistanceForVotes ID\n";  
  print "            ID - id della votazione\n";
  exit;
}

$votazione_id = $argv[1];
if (!is_int($votazione_id))
{
  print "l'id deve essere almeno un intero \n";  
  exit;  
}
$votazione = OppVotazionePeer::retrieveFromPK($votazione_id);
if ($votazione !instanceof OppVotazione)
{
  print "l'id non corrisponde a nessuna votazione \n";  
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


// estrae ramo e legislatura
$seduta = $votazione->getOppSeduta();
$ramo = $seduta->getRamo();
$legislatura = $seduta->getLegislatura();

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
  
  // legge il voto del politico
  $vc = OppVotazioneHasCaricaPeer::retrieveByPK($votazione_id, $carica->getId());
  $voti = array($vc->getVoto());

  $politici[$i]['voti'] = $voti;
  unset($res);
  
  echo " \n";
}


// aggiornamento della matrice simmetrica delle similarità
for ($i = 0; $i<$ncariche; $i++)
{
  for ($j = $i+1; $j<$ncariche; $j++)
  {
    $d = OppSimilaritaPeer::retrieveByPK($politici[$i]['id'], $politici[$j]['id']);
    $d->increaseVotingSimilarity(OppSimilaritaPeer::similarityForVotes($politici[$i], $politici[$j], $ramo) / $ncariche);
    $d->save();
    
    // scrittura elemento simmetrico
    $ds = OppSimilaritaPeer::retrieveByPK($politici[$j]['id'], $politici[$i]['id']);
    $ds->setVotingSimilarity($d->getVotingSimilarity());
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



