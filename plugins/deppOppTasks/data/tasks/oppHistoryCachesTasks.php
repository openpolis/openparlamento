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
    $cache_record = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiId($data_lookup, 'P', $id);
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
        $cache_record = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiId($data_lookup, 'G', $id);
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
