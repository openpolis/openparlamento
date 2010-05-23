<?php
/*
 * This file is part of the deppOppTasks package.
 *
 * (c) 2010 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * @package    
 * @subpackage Task per riempire le history_caches (politici, atti e tag)
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("costruisce cache per politici");
pake_task('opp-build-cache-politici', 'project_exists');

pake_desc("costruisce cache per gruppi");
pake_task('opp-build-cache-gruppi', 'project_exists');

pake_desc("costruisce cache per rami");
pake_task('opp-build-cache-rami', 'project_exists');

pake_desc("ri-costruisce dati dei delta per gli storici");
pake_task('opp-rebuild-deltas', 'project_exists');


/**
 * Calcola o ri-calcola i dati da cachare per i politici
 * Si può specificare:
 * - il ramo (camera, senato, governo, parlamento, tutti*)
 * - la data (da inizio legislatura a quella data)
 * Se sono passati degli ID (argomenti), sono interpretati come ID di politici e il calcolo è fatto solo per loro
 * L'opzione --verbose, permette di visualizzare il dettaglio dei calcoli svolti
 */
function run_opp_build_cache_politici($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    task_loader();
    $loaded = true;
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";

  $msg = sprintf("start time: %s\n", date('H:i:s'));
  echo $msg;

  $data = '';
  $ramo = 'tutti';
  $tipo = 'P';
  $verbose = false;
  if (array_key_exists('data', $options)) {
    $data = $options['data'];
  }
  if (array_key_exists('ramo', $options)) {
    $ramo = strtolower($options['ramo']);
  }
  if (array_key_exists('verbose', $options)) {
    $verbose = true;
  }


  // definisce la data fino alla quale vanno fatti i calcoli
  // data_lookup serve per controllare se i record già esistono
  if ($data != '') {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent($data);
    $data_lookup = $data;
  } else {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent();
    $data = date('Y-m-d');
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData();
  }


  $msg = sprintf("data: %s, ramo: %s\n", $data, $ramo);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


  if (count($args) > 0)
  {
    try {
      $parlamentari_rs = OppCaricaPeer::getRSFromIDArray($args);            
    } catch (Exception $e) {
      throw new Exception("Specificare degli ID validi. \n" . $e);
    }
  } else {
    $parlamentari_rs = OppCaricaPeer::getParlamentariRamoDataRS($ramo, $legislatura_corrente, $data);    
  }

  $cnt = 0;
  while ($parlamentari_rs->next())
  {
    $cnt++;
    
    $p = $parlamentari_rs->getRow();
    $nome = $p['nome'];
    $cognome = $p['cognome'];
    $tipo_carica_id = $p['tipo_carica_id'];
    $id = $p['id'];
    
    list($mio_ramo, $prefisso) = OppTipoCaricaPeer::getRamoPrefisso($tipo_carica_id);
    $gruppo = OppCaricaPeer::getGruppo($id, $data);

    $politico_stringa = sprintf("%s %s %s", $prefisso, $nome, strtoupper($cognome));
    printf("%4d) %40s %7s [%06d] ... ", $cnt, $politico_stringa, "(".$gruppo['acronimo'].")", $id);

    $indice = OppIndiceAttivitaPeer::calcola_vecchio_indice($id, $legislatura_corrente, $data, $verbose);
    list($presenze, $assenze, $missioni) = OppVotazioneHasCaricaPeer::getDatiPresenzaCaricaData($id, $legislatura_corrente, $data);
    $ribellioni = OppVotazioneHasCaricaPeer::countRibellioniCaricaData($id, $legislatura_corrente, $data);

    // inserimento o aggiornamento del valore in opp_politician_history_cache
    $cache_record = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiIdRamo($data_lookup, 'P', $id, $mio_ramo);
    if (!$cache_record) {
      $cache_record = new OppPoliticianHistoryCache();
    }
    $cache_record->setLegislatura($legislatura_corrente);
    $cache_record->setChiTipo('P');
    $cache_record->setChiId($id);
    $cache_record->setRamo($mio_ramo);
    $cache_record->setGruppoId($gruppo['id']);
    $cache_record->setIndice($indice);
    $cache_record->setPresenze($presenze);
    $cache_record->setAssenze($assenze);
    $cache_record->setMissioni($missioni);
    $cache_record->setRibellioni($ribellioni);
    $cache_record->setData($data);
    $cache_record->setNumero(1); // il dato riguarda un solo soggetto
    $cache_record->setUpdatedAt(date('Y-m-d H:i')); // forza riscrittura updated_at, per tenere traccia esecuzioni
    $cache_record->save();
    unset($cache_record);

    $msg = sprintf("i: %7.2f   p:%4d    a:%4d   m:%4d,   r:%4d", $indice, $presenze, $assenze, $missioni, $ribellioni);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    echo "\n";

  }


  $msg = sprintf("end time: %s\n", date('H:i:s'));
  echo $msg;

  $msg = sprintf("memory usage: %10d\n", memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  
  $msg = sprintf("%d parlamentari elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));
}


/**
 * Calcola o ri-calcola i dati aggregati da cachare per i gruppi
 * Si può specificare:
 * - il ramo (camera, senato, governo, parlamento, tutti*)
 * - la data (da inizio legislatura a quella data)
 * Se sono passati degli ID (argomenti), sono interpretati come ID di gruppi e il calcolo è fatto solo per loro
 */
function run_opp_build_cache_gruppi($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    task_loader();
    $loaded = true;
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";

  $msg = sprintf("start time: %s\n", date('H:i:s'));
  echo $msg;

  $data = '';
  $ramo_esteso = 'parlamento';
  $verbose = false;
  if (array_key_exists('data', $options)) {
    $data = $options['data'];
  }
  if (array_key_exists('ramo', $options)) {
    $ramo_esteso = $options['ramo'];
  }
  if (array_key_exists('verbose', $options)) {
    $verbose = true;
  }
  

  // definisce la data fino alla quale vanno fatti i calcoli
  // data_lookup serve per controllare se i record già esistono
  if ($data != '') {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent($data);
    $data_lookup = $data;
  } else {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent();
    $data = date('Y-m-d');
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData();
  }

  // costruisce array di rami a partire da ramo esteso
  switch ($ramo_esteso) {
    case 'parlamento':
    case 'tutti':
      $rami = array('C', 'S');
      break;
    case 'camera':
      $rami = array('C');
      break;
    case 'senato':
      $rami = array('S');
      break;
    
    default:
      $rami = array();
      break;
  }
  
  foreach ($rami as $ramo) {

    $msg = sprintf("calcolo aggregazione per gruppi - data: %s, ramo: %s\n", $data, $ramo);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

    if (count($args) > 0)
    {
      try {
        $gruppi_rs = OppGruppoPeer::getRSFromIDArray($args);            
      } catch (Exception $e) {
        throw new Exception("Specificare degli ID validi. \n" . $e);
      }
    } else {
      $gruppi_rs = OppGruppoPeer::getGruppiRamoDataRS($ramo, $data);    
    }

    $cnt = 0;
    while ($gruppi_rs->next())
    {
      $cnt++;
    
      $g = $gruppi_rs->getRow();
      $nome = $g['nome'];
      $acronimo = $g['acronimo'];
      $id = $g['id'];
    
      printf("%4d) %30s (%10s) [%06d] ... ", $cnt, $nome, $acronimo, $id);

      $numero = OppPoliticianHistoryCachePeer::countRecordsGruppoRamoData($id, $ramo, $data);

      if ($numero > 0)
      {
        $dati = OppPoliticianHistoryCachePeer::aggregaDatiGruppoRamoData($id, $ramo, $data);
        
        // inserimento o aggiornamento del valore in opp_politician_history_cache
        $cache_record = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiIdRamo($data_lookup, 'G', $id, $ramo);
        if (!$cache_record) {
          $cache_record = new OppPoliticianHistoryCache();
        }
        $cache_record->setLegislatura($legislatura_corrente);
        $cache_record->setChiTipo('G');
        $cache_record->setChiId($id);
        $cache_record->setRamo($ramo);
        $cache_record->setGruppoId($id); // ridondante, ma ok
        $cache_record->setIndice($dati['indice']);
        $cache_record->setPresenze($dati['presenze']);
        $cache_record->setAssenze($dati['assenze']);
        $cache_record->setMissioni($dati['missioni']);
        $cache_record->setRibellioni($dati['ribellioni']);
        $cache_record->setData($data);
        $cache_record->setNumero($numero); // serve per ricostruire la somma aggregata
        $cache_record->setUpdatedAt(date('Y-m-d H:i')); // forza riscrittura updated_at, per tenere traccia esecuzioni
        $cache_record->save();
        unset($cache_record);

        $msg = sprintf("i: %7.2f  p:%7.2f  a:%7.2f  m:%7.2f   r:%7.2f (su %d membri)", 
                       $dati['indice'], 
                       $dati['presenze'], 
                       $dati['assenze'], 
                       $dati['missioni'], 
                       $dati['ribellioni'], 
                       $numero);
        echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

      } else {
        $msg = sprintf("nessun dato da aggregare!");
        echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      
      }

      echo "\n";
    }
    
  }

  $msg = sprintf("end time: %s\n", date('H:i:s'));
  echo $msg;

  $msg = sprintf("memory usage: %10d\n", memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  
}


/**
 * Calcola o ri-calcola i dati aggregati da cachare per i rami
 * Si può specificare:
 * - la data (da inizio legislatura a quella data)
 */
function run_opp_build_cache_rami($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    task_loader();
    $loaded = true;
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";

  $msg = sprintf("start time: %s\n", date('H:i:s'));
  echo $msg;

  $data = '';
  $verbose = false;
  if (array_key_exists('data', $options)) {
    $data = $options['data'];
  }
  if (array_key_exists('verbose', $options)) {
    $verbose = true;
  }
  

  // definisce la data fino alla quale vanno fatti i calcoli
  // data_lookup serve per controllare se i record già esistono
  if ($data != '') {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent($data);
    $data_lookup = $data;
  } else {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent();
    $data = date('Y-m-d');
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData();
  }
  
  foreach (array('C', 'S') as $ramo) {

    $msg = sprintf("calcolo aggregazione per intero ramo - data: %s, ramo: %s\n", $data, $ramo);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

    $numero = OppPoliticianHistoryCachePeer::countRecordsRamoData($ramo, $data);

    if ($numero > 0)
    {
      $dati = OppPoliticianHistoryCachePeer::aggregaDatiRamoData($ramo, $data);
      
      // inserimento o aggiornamento del valore in opp_politician_history_cache
      $cache_record = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoRamo($data_lookup, 'R', $ramo);
      if (!$cache_record) {
        $cache_record = new OppPoliticianHistoryCache();
      }
      $cache_record->setLegislatura($legislatura_corrente);
      $cache_record->setChiTipo('R');
      $cache_record->setRamo($ramo);
      $cache_record->setIndice($dati['indice']);
      $cache_record->setPresenze($dati['presenze']);
      $cache_record->setAssenze($dati['assenze']);
      $cache_record->setMissioni($dati['missioni']);
      $cache_record->setRibellioni($dati['ribellioni']);
      $cache_record->setData($data);
      $cache_record->setNumero($numero); // serve per ricostruire la somma aggregata
      $cache_record->setUpdatedAt(date('Y-m-d H:i')); // forza riscrittura updated_at, per tenere traccia esecuzioni
      $cache_record->save();
      unset($cache_record);

      $msg = sprintf("i: %7.2f  p:%7.2f  a:%7.2f  m:%7.2f   r:%7.2f (su %d membri)", 
                     $dati['indice'], 
                     $dati['presenze'], 
                     $dati['assenze'], 
                     $dati['missioni'], 
                     $dati['ribellioni'], 
                     $numero);
      echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    } else {
      $msg = sprintf("nessun dato da aggregare per questo ramo!");
      echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      
    }

    echo "\n";
    
  }

  $msg = sprintf("end time: %s\n", date('H:i:s'));
  echo $msg;

  $msg = sprintf("memory usage: %10d\n", memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  
}


function run_opp_rebuild_deltas($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    task_loader();
    $loaded = true;
  }

  $data = '';
  $dry_run = false;
  if (array_key_exists('data', $options)) {
    $data = $options['data'];
  }
  if (array_key_exists('dry-run', $options)) {
    $dry_run = true;
  }
  

  // definisce la data fino alla quale vanno fatti i calcoli
  // data_lookup serve per controllare se i record già esistono
  if ($data != '') {
    $data_lookup = $data;
  } else {
    $data = date('Y-m-d');
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData();
  }

  $msg = sprintf("start time: %s\n", date('H:i:s'));
  echo $msg;
  
  $rs = OppPoliticianHistoryCachePeer::getRSByDataRamoChiTipo($data_lookup);
  $cnt = 0;
  while ($rs->next()) {
    $cnt++;
    $r = $rs->getRow();
    printf("%6d) %1s %7d ... ", $cnt, $r['chi_tipo'], $r['chi_id']);
    
    // calcolo date fine mese scorso e precedente
    list($data_1, $data_2) = Util::getLast2MonthsDate($data);

    // estrazione record storici a due mesi
    $r_1 = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiIdRamo($data_1, $r['chi_tipo'], $r['chi_id'], $r['ramo']);
    $r_2 = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiIdRamo($data_2, $r['chi_tipo'], $r['chi_id'], $r['ramo']);

    // salta record per cui non c'è abbastanza storia
    if (!$r_1 instanceof OppPoliticianHistoryCache ||
        !$r_2 instanceof OppPoliticianHistoryCache)
    {
      printf(" NA \n");
      continue;
    }
    
    list($presenze_delta, $assenze_delta, $missioni_delta) = presenzeDelta($data_lookup, $r, $r_1, $r_2);
    printf("d_presenze: %7.2f,  d_assenze: %7.2f,  d_missioni: %7.2f,  ", 
           $presenze_delta, $assenze_delta, $missioni_delta);
    $indice_delta = indiceDelta($data_lookup, $r, $r_1, $r_2, $data_1, $data_2);
    printf("d_indice: %7.2f,  ", $indice_delta);
    $ribellioni_delta = ribellioniDelta($data_lookup, $r, $r_1, $r_2, $data_1, $data_2);
    printf("d_ribellioni: %7.2f", $ribellioni_delta);
    
    if (!$dry_run) {
      $r = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiIdRamo($data_lookup, $r['chi_tipo'], $r['chi_id'], $r['ramo']);
      $r->setPresenzeDelta($presenze_delta);
      $r->setAssenzeDelta($assenze_delta);
      $r->setMissioniDelta($missioni_delta);
      $r->setIndiceDelta($indice_delta);
      $r->setRibellioniDelta($ribellioni_delta);
      $r->save();
      printf(" OK!\n");
    } else {
      printf("\n");
    }
  }
  
  echo "data: $data_lookup\n";
  
  $msg = sprintf("end time: %s\n", date('H:i:s'));
  echo $msg;
  
}


function ribellioniDelta($data, $r, $r_1, $r_2)
{
  // calcolo indice
  $ribellioni = (float)($r['ribellioni']);                   // complessive fino a oggi
  $ribellioni_fine_1 = (float)$r_1->getribellioni();         // complessive fino a fine mese scorso
  $ribellioni_1 = $ribellioni - $ribellioni_fine_1;          // questo mese
  $ribellioni_fine_2 = (float)$r_2->getribellioni();         // complessive fino a fine due mesi fa
  $ribellioni_2 = $ribellioni_fine_1 - $ribellioni_fine_2;   // il mese scorso
  
  // calcolo presenze
  $presenze = (float)($r['presenze']);               // complessive fino a oggi
  $presenze_fine_1 = (float)$r_1->getPresenze();     // complessive fino a fine mese scorso
  $presenze_1 = $presenze - $presenze_fine_1;        // questo mese
  $presenze_fine_2 = (float)$r_2->getPresenze();     // complessive fino a fine due mesi fa
  $presenze_2 = $presenze_fine_1 - $presenze_fine_2; // il mese scorso

  // calcolo valori normalizzati
  if ($presenze_1 == 0)
    $ribellioni_1_norm = 0.;
  else
    $ribellioni_1_norm = $ribellioni_1 / $presenze_1;
    
  if ($presenze_2 == 0)
    $ribellioni_2_norm = 0.;
  else
    $ribellioni_2_norm = $ribellioni_2 / $presenze_2;
  
  // estrazione delta
  return 100*($ribellioni_1_norm - $ribellioni_2_norm);
}

function indiceDelta($data, $r, $r_1, $r_2, $data_1, $data_2)
{
  // calcolo indice
  $indice = (float)($r['indice']);              // complessive fino a oggi
  $indice_fine_1 = (float)$r_1->getIndice();    // complessive fino a fine mese scorso
  $indice_1 = $indice - $indice_fine_1;         // questo mese
  $indice_fine_2 = (float)$r_2->getIndice();    // complessive fino a fine due mesi fa
  $indice_2 = $indice_fine_1 - $indice_fine_2;  // il mese scorso
  
  // calcolo numero giorni
  $giorni = (float)date('d', strtotime($data));
  $giorni_1 = (float)date('d', strtotime($data_1));
  $giorni_2 = (float)date('d', strtotime($data_2));

  // calcolo valori normalizzati
  $indice_1_norm = $indice_1 / $giorni_1;
  $indice_2_norm = $indice_2 / $giorni_2;
  
  // estrazione delta
  return $indice_1_norm - $indice_2_norm;
}


function presenzeDelta($data, $r, $r_1, $r_2)
{
  // calcolo presenze
  $presenze = (float)($r['presenze']);               // complessive fino a oggi
  $presenze_fine_1 = (float)$r_1->getPresenze();     // complessive fino a fine mese scorso
  $presenze_1 = $presenze - $presenze_fine_1;        // questo mese
  $presenze_fine_2 = (float)$r_2->getPresenze();     // complessive fino a fine due mesi fa
  $presenze_2 = $presenze_fine_1 - $presenze_fine_2; // il mese scorso
  
  // calcolo assenze
  $assenze = (float)($r['assenze']);
  $assenze_fine_1 = (float)$r_1->getAssenze();
  $assenze_1 = $assenze - $assenze_fine_1;
  $assenze_fine_2 = (float)$r_2->getAssenze();
  $assenze_2 = $assenze_fine_1 - $assenze_fine_2;
  
  // calcolo missione
  $missioni = (float)($r['missioni']);
  $missioni_fine_1 = (float)$r_1->getMissioni();
  $missioni_1 = $missioni - $missioni_fine_1;
  $missioni_fine_2 = (float)$r_2->getMissioni();
  $missioni_2 = $missioni_fine_1 - $missioni_fine_2;
  
  // calcolo totale votazioni
  $votazioni = $presenze + $assenze + $missioni;
  $votazioni_1 = $presenze_1 + $assenze_1 + $missioni_1;
  $votazioni_2 = $presenze_2 + $assenze_2 + $missioni_2;

  // calcolo valori normalizzati
  if ($votazioni_1 == 0)
  {
    $presenze_1_norm = 0; $assenze_1_norm = 0; $missioni_1_norm = 0;    
  }
  else
  {
    $presenze_1_norm = $presenze_1 / $votazioni_1;
    $assenze_1_norm = $assenze_1 / $votazioni_1;
    $missioni_1_norm = $missioni_1 / $votazioni_1;    
  }
  
  if ($votazioni_2 == 0)
  {
    $presenze_2_norm = 0; $assenze_2_norm = 0; $missioni_2_norm = 0;    
  }
  else 
  {
    $presenze_2_norm = $presenze_2 / $votazioni_2;
    $assenze_2_norm = $assenze_2 / $votazioni_2;
    $missioni_2_norm = $missioni_2 / $votazioni_2;
  }
  
  // estrazione delta
  $presenze_delta = $presenze_1_norm - $presenze_2_norm;
  $assenze_delta = $assenze_1_norm - $assenze_2_norm;
  $missioni_delta = $missioni_1_norm - $missioni_2_norm;
  return array($presenze_delta*100., $assenze_delta*100., $missioni_delta*100.);
}


function task_loader($value='')
{
  define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
  define('SF_APP', 'fe');
  define('SF_ENVIRONMENT', 'task');
  define('SF_DEBUG', false);

  require_once (SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.
                DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.
                DIRECTORY_SEPARATOR.'config.php');


  sfContext::getInstance();
  sfConfig::set('pake', true);
  
  error_reporting(E_ALL);
}
