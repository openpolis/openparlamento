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

pake_desc("costruisce cache per gli atti");
pake_task('opp-build-cache-atti', 'project_exists');

pake_desc("calcola i dati dei delta per la cache dei politici (percentuali di presenze, indici, ribellioni)");
pake_task('opp-compute-delta-politici', 'project_exists');

pake_desc("calcola i dati dei delta per la cache degli atti");
pake_task('opp-compute-delta-atti', 'project_exists');

pake_desc("calcola i dati dei delta per la cache dei tag");
pake_task('opp-compute-delta-tag', 'project_exists');

/*
pake_desc("calcola i dati delle posizioni per la cache dei politici");
pake_task('opp-compute-positions-politicians', 'project_exists');

pake_desc("calcola i dati delle posizioni per la cache degli atti");
pake_task('opp-compute-positions-acts', 'project_exists');

pake_desc("calcola i dati delle posizioni per la cache dei tag");
pake_task('opp-compute-positions-tags', 'project_exists');
*/


/**
 * Calcola o ri-calcola i dati da cachare per i politici
 * - presenze, assenze, missioni
 * - indice di attività (nuovo)
 * - ribellioni
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

  // restrizione su un subset di atti/emendamenti per eventuale debug
  $atti_ids = array();
  if (array_key_exists('atti', $options)) {
    $atti_ids = explode(",", $options['atti']);
  }
  $emendamenti_ids = array();
  if (array_key_exists('emendamenti', $options)) {
    $emendamenti_ids = explode(",", $options['emendamenti']);
  }

  // definisce la data fino alla quale vanno fatti i calcoli
  // data_lookup serve per controllare se i record già esistono
  if ($data != '') {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent($data);
    $data_lookup = $data;
  } else {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent();
    $data = date('Y-m-d');
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData('P');
  }

  $msg = sprintf("calcolo cache per politici data: %10s, ramo: %10s\n", $data?$data:'-', $ramo);
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

  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();

  $cnt = 0;
  $indice_ar = array(); $presenze_ar = array(); $missioni_ar = array(); $assenze_ar = array();
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

    $indice = OppIndiceAttivitaPeer::calcola_indice_politico($id, $legislatura_corrente, $data, $verbose);
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
    $record_id = $cache_record->getId();
    unset($cache_record);

    # store values in an array, to sort them later and get positions
    $indice_ar   []= array($record_id => $indice);
    $presenze_ar []= array($record_id => $presenze);
    $missioni_ar []= array($record_id => $missioni);
    $assenze_ar  []= array($record_id => $assenze);

    $msg = sprintf("i: %7.2f   p:%4d    a:%4d   m:%4d,   r:%4d", $indice, $presenze, $assenze, $missioni, $ribellioni);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
    echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      


  }
  
  # update positions
  krsort($indice_ar);
  krsort($presenze_ar);
  krsort($missioni_ar);
  krsort($assenze_ar);  
  foreach ($indice_ar as $record_id => $value) {
   $cached_record = OppPoliticianHistoryCachePeer::retrieveByPK($record_id);
   $cached_record->setIndicePos($value);
   $cached_record->setPresenzePos($presenze_ar[$record_id]);
   $cached_record->setMissioniPos($missioni_ar[$record_id]);
   $cached_record->setAssenzePos($assenze_ar[$record_id]);    
   $cached_record->save();
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
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData('G');
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
    
      printf("%4d) %30s (%10s) [%6d] ... ", $cnt, $nome, $acronimo, $id);

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
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData('R');
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



/**
 * Calcola o ri-calcola la cache dell'indice di rilevanza degli atti
 * Si può specificare il una data fino alla quale calcolare la rilevanza
 * Se sono passati degli ID (argomenti), sono interpretati come ID di atti e il calcolo è fatto solo per loro
 */
function run_opp_build_cache_atti($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    task_loader();
    $loaded = true;
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";


  $data = '';
  $verbose = false;
  $offset = null;
  $limit = null;
  if (array_key_exists('data', $options)) {
    $data = $options['data'];
  }
  if (array_key_exists('verbose', $options)) {
    $verbose = true;
  }
  if (array_key_exists('offset', $options)) {
    $offset = $options['offset'];
  }
  if (array_key_exists('limit', $options)) {
    $limit = $options['limit'];
  }

  if ($data != '') {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent($data);
    $data_lookup = $data;
  } else {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent();
    $data = date('Y-m-d');
    $data_lookup = OppActHistoryCachePeer::fetchLastData();
  }


  $msg = sprintf("calcolo rilevanza - fino a: %10s\n", $data);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $start_time = time();
  
  if (count($args) > 0)
  {
    try {
      $atti_rs = OppAttoPeer::getRSFromIDArray($args);            
    } catch (Exception $e) {
      throw new Exception("Specificare degli ID validi. \n" . $e);
    }
  } else {
    $atti_rs = OppAttoPeer::getAttiDataRS($data, $offset, $limit);    
  }

  $n_atti = $atti_rs->getRecordCount();

  echo "memory usage: " . memory_get_usage( ) . "\n";

  $cnt = 0;
  while ($atti_rs->next())
  {
    $a = $atti_rs->getRow();

    $atto_id = $a['id'];
    $tipo_atto_id = $a['tipo_atto_id'];

    $cnt++;

    $atto = OppAttoPeer::retrieveByPK($atto_id);
    if (!array_key_exists($tipo_atto_id, OppTipoAttoPeer::$tipi_per_indice)) continue;
    
    printf("%5d/%6d) %40s %d ... ", $cnt, $n_atti, OppTipoAttoPeer::$tipi_per_indice[$tipo_atto_id], $atto_id);
    $indice = OppIndiceRilevanzaPeer::calcola_rilevanza_atto($atto, $tipo_atto_id, $data, $verbose);

    // inserimento o aggiornamento del valore in opp_politician_history_cache
    $cache_record = OppActHistoryCachePeer::retrieveByDataChiTipoChiId($data_lookup, 'A', $atto_id);
    if (!$cache_record) {
      $cache_record = new OppActHistoryCache();
    }
    $cache_record->setLegislatura($legislatura_corrente);
    $cache_record->setChiTipo('A');
    $cache_record->setChiId($atto_id);
    $cache_record->setTipoAttoId($tipo_atto_id);
    $cache_record->setIndice($indice);
    $cache_record->setData($data);
    $cache_record->setUpdatedAt(date('Y-m-d H:i')); // forza riscrittura updated_at, per tenere traccia esecuzioni
    $cache_record->save();
    unset($cache_record);

    $msg = sprintf("%7.2f", $indice);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
    echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      

    
  }

  $msg = sprintf("%d atti elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


}



function run_opp_compute_delta_politici($task, $args, $options)
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
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData();
  }

  $msg = sprintf("start time: %s\n", date('H:i:s'));
  echo $msg;

  // calcolo date inizio e fine mese scorso
  list($last_month_start, $last_month_end) = Util::getLastMonthDates($data_lookup);
  
  // calcolo delta per dati di presenza, indice e ribellioni
  $rs = OppPoliticianHistoryCachePeer::getRSByDataRamoChiTipo($data_lookup);
  $cnt = 0;
  while ($rs->next()) {
    $cnt++;
    $r = $rs->getRow();
    printf("%6d) %1s %7d ... ", $cnt, $r['chi_tipo'], $r['chi_id']);
    
    // estrazione record storico alla fine del mese scorso
    $r_1 = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiIdRamo($last_month_end, $r['chi_tipo'], $r['chi_id'], $r['ramo']);
    
    // salta record per cui non c'è abbastanza storia
    if (!$r_1 instanceof OppPoliticianHistoryCache)
    {
      printf(" NA \n");
      continue;
    }
    
    list($presenze_delta, $assenze_delta, $missioni_delta) = presenzeDelta($data_lookup, $r, $r_1);
    printf("presenze: %7.2f%%,  assenze: %7.2f%%,  missioni: %7.2f%%,  ", 
           $presenze_delta, $assenze_delta, $missioni_delta);

    $indice_delta = indiceDelta($data_lookup, $r, $r_1);
    printf("indice: %8.4f,  ", $indice_delta);

    $ribellioni_delta = ribellioniDelta($data_lookup, $r, $r_1);
    printf("ribellioni: %7.2f%%", $ribellioni_delta);
    
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


function run_opp_compute_delta_atti($task, $args, $options)
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
    $data_lookup = OppActHistoryCachePeer::fetchLastData();
  }

  $msg = sprintf("start time: %s\n", date('H:i:s'));
  echo $msg;

  // calcolo date fine mese scorso e precedente
  list($last_month_start, $last_month_end) = Util::getLastMonthDates($data_lookup);

  // calcolo delta per dati di presenza, indice e ribellioni
  $rs = OppActHistoryCachePeer::getRSByData($data_lookup);
  $cnt = 0;
  while ($rs->next()) {
    $cnt++;
    $r = $rs->getRow();
    printf("%6d) %1s %7d ... ", $cnt, $r['chi_tipo'], $r['chi_id']);
    
    // estrazione record storico del mese scorso
    $r_1 = OppActHistoryCachePeer::retrieveByDataChiTipoChiId($last_month_end, $r['chi_tipo'], $r['chi_id']);

    // salta record per cui non c'è abbastanza storia
    if (!$r_1 instanceof OppActHistoryCache)
    {
      printf(" NA \n");
      continue;
    }
    
    $rilevanza_delta = indiceDelta($data_lookup, $r, $r_1);
    printf("d_rilevanza: %7.2f,  ", $rilevanza_delta);
    
    if (!$dry_run) {
      $r = OppActHistoryCachePeer::retrieveByDataChiTipoChiId($data_lookup, $r['chi_tipo'], $r['chi_id']);
      $r->setIndiceDelta($rilevanza_delta);
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


function run_opp_compute_delta_tag($task, $args, $options)
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
    $data_lookup = OppTagHistoryCachePeer::fetchLastData();
  }

  $msg = sprintf("start time: %s\n", date('H:i:s'));
  echo $msg;

  // calcolo date fine mese scorso e precedente
  list($last_month_start, $last_month_end) = Util::getLastMonthDates($data_lookup);

  // calcolo delta per dati di presenza, indice e ribellioni
  $rs = OppTagHistoryCachePeer::getRSByData($data_lookup);
  $cnt = 0;
  while ($rs->next()) {
    $cnt++;
    $r = $rs->getRow();
    printf("%6d) %1s %7d ... ", $cnt, $r['chi_tipo'], $r['chi_id']);
    
    // estrazione record storico del mese scorso
    $r_1 = OppTagHistoryCachePeer::retrieveByDataChiTipoChiId($last_month_end, $r['chi_tipo'], $r['chi_id']);

    // salta record per cui non c'è abbastanza storia
    if (!$r_1 instanceof OppTagHistoryCache)
    {
      printf(" NA \n");
      continue;
    }
    
    $rilevanza_delta = indiceDelta($data_lookup, $r, $r_1);
    printf("d_rilevanza: %7.2f,  ", $rilevanza_delta);
    
    if (!$dry_run) {
      $r = OppTagHistoryCachePeer::retrieveByDataChiTipoChiId($data_lookup, $r['chi_tipo'], $r['chi_id']);
      $r->setIndiceDelta($rilevanza_delta);
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


/**
 * calcola o ri-calcola le posizioni per indici e presenze
 * nelle tabelle cache, a una determinata data (o a tutte)
 *
 * @param string $task 
 * @param string $args 
 * @param string $options 
 * @return void
 * @author Guglielmo Celata
 */
function run_opp_rebuild_positions($task, $args, $options)
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
  
  $msg = sprintf("start time: %s\n", date('H:i:s'));
  echo $msg;
  
  if ($data != '') {
    $p_dates = array($data => $data);
  }
  $p_dates = OppPoliticianHistoryCachePeer::extractDates('N', null, 10000);
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


/**
 * calcola il contributo medio giornaliero per il mese
 *
 * @param string $data        la data del mese considerato in corso
 * @param string $r           hash - i dati del mese in corso
 * @param string $r_1         recordset - i dati del mese scorso
 * @return float
 * @author Guglielmo Celata
 */
function indiceDelta($data, $r, $r_1)
{
  // contributo all'indice del mese in corso
  $indice = (float)($r['indice']) - (float)$r_1->getIndice();
  
  // numero giorni del mese in corso
  $giorni = (float)date('d', strtotime($data));

  // contributo medio giornaliero mese in corso
  return $indice / $giorni;
}


/**
 * calcola le percentuali di presenze, assenze e missioni di un mese
 *
 * @param string $data        la data del mese considerato in corso
 * @param string $r           hash - i dati del mese in corso
 * @param string $r_1         recordset - i dati del mese scorso
 * @return array di tre elementi float
 * @author Guglielmo Celata
 */
function presenzeDelta($data, $r, $r_1)
{
  // calcolo presenze per il mese
  $presenze = (float)($r['presenze']) - (float)$r_1->getPresenze();
  
  // calcolo assenze per il mese
  $assenze = (float)($r['assenze']) - (float)$r_1->getAssenze();
  
  // calcolo missione per il mese
  $missioni = (float)($r['missioni']) - (float)$r_1->getMissioni();
  
  // calcolo totale votazioni del mese
  $votazioni = $presenze + $assenze + $missioni;

  // calcolo valori normalizzati (perc di pres/ass/miss sul totale delle votazioni)
  if ($votazioni == 0)
  {
    $presenze_norm = 0; $assenze_norm = 0; $missioni_norm = 0;    
  }
  else
  {
    $presenze_norm = $presenze / $votazioni;
    $assenze_norm = $assenze / $votazioni;
    $missioni_norm = $missioni / $votazioni;    
  }
  
  return array($presenze_norm*100., $assenze_norm*100., $missioni_norm*100.);
}


/**
 * calcola la percentuale di ribellioni su presenze per il mese in corso
 *
 * @param string $data        la data del mese considerato in corso
 * @param string $r           hash - i dati del mese in corso
 * @param string $r_1         recordset - i dati del mese scorso
 * @return float
 * @author Guglielmo Celata
 */
function ribellioniDelta($data, $r, $r_1)
{
  // calcolo ribellioni per questo mese
  $ribellioni = (float)($r['ribellioni']) - (float)$r_1->getribellioni();
  
  // calcolo presenze per questo mese
  $presenze = (float)($r['presenze']) - (float)$r_1->getPresenze();

  // calcolo valori normalizzati (perc di ribellioni su presenze)
  if ($presenze == 0)
    $ribellioni_norm = 0.;
  else
    $ribellioni_norm = $ribellioni / $presenze;
    
  // ritorna la percentuale di ribellioni/presenze per il mese in corso
  return $ribellioni_norm * 100.;
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
