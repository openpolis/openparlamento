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
 * @subpackage Task per computare dati (presenze, indice attività)
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("calcola l'indice di attività");
pake_task('opp-calcola-indice', 'project_exists');

pake_desc("calcola la rilevanza per gli atti");
pake_task('opp-calcola-rilevanza-atti', 'project_exists');

pake_desc("calcola la rilevanza per gli argomenti");
pake_task('opp-calcola-rilevanza-tag', 'project_exists');

/**
 * Calcola o ri-calcola l'indice di attività.
 * Si può specificare il ramo (camera, senato, governo, tutti) e il periodo (legislatura[tutto], anno, mese, settimana)
 * Se sono passati degli ID (argomenti), sono interpretati come ID di politici e il calcolo è fatto solo per loro
 */
function run_opp_calcola_indice($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
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

    $loaded = true;
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";


  $data = '';
  $ramo = '';
  $verbose = false;
  $offset = null;
  $limit = null;
  if (array_key_exists('data', $options)) {
    $data = $options['data'];
  }
  if (array_key_exists('ramo', $options)) {
    $ramo = strtolower($options['ramo']);
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


  $msg = sprintf("calcolo indice di attività - settimana: %10s, ramo: %10s\n", $data?$data:'-', $ramo);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


  if (count($args) > 0)
  {
    try {
      $parlamentari_rs = OppCaricaPeer::getRSFromIDArray($args);            
    } catch (Exception $e) {
      throw new Exception("Specificare degli ID validi. \n" . $e);
    }
  } else {
    $parlamentari_rs = OppCaricaPeer::getParlamentariRamoDataRS($ramo, $data, $offset, $limit);    
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";

  $cnt = 0;
  while ($parlamentari_rs->next())
  {
    $cnt++;
    
    $p = $parlamentari_rs->getRow();
    $nome = $p['nome'];
    $cognome = $p['cognome'];
    $tipo_carica_id = $p['tipo_carica_id'];
    $id = $p['id'];
    switch ($tipo_carica_id) {
      case 1:
        $ramo = 'C';
        $prefisso = 'On.';
        break;
      case 4:
      case 5:
        $ramo = 'S';
        $prefisso = 'Sen.';
        break;
      case 2:
      case 3:
      case 6:
      case 7:
        $ramo = 'G';
        $prefisso = '';
        break;
      
      default:
        break;
    }

    $politico_stringa = sprintf("%s %s %s", $prefisso, $nome, strtoupper($cognome));
    printf("%4d) %40s [%06d] ... ", $cnt, $politico_stringa, $id);
    $indice = OppIndiceAttivitaPeer::calcola_indice_politico($id, $data, $verbose);

    // inserimento o aggiornamento del valore in opp_politician_history_cache
    // prendo il valore d
    $cache_record = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiId($data_lookup, 'P', $id);
    if (!$cache_record) {
      $cache_record = new OppPoliticianHistoryCache();
    }
    $cache_record->setLegislatura($legislatura_corrente);
    $cache_record->setChiTipo('P');
    $cache_record->setChiId($id);
    $cache_record->setRamo($ramo);
    $cache_record->setIndice($indice);
    $cache_record->setData($data);
    $cache_record->setUpdatedAt(date('Y-m-d H:i')); // forza riscrittura updated_at, per tenere traccia esecuzioni
    $cache_record->save();
    unset($cache_record);

    $msg = sprintf("%7.2f", $indice);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    $msg = sprintf(" %10d\n", memory_get_usage( ));
    echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  }

  
  $msg = sprintf("%d parlamentari elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));
}

/**
 * Calcola o ri-calcola la rilevanza degli atti
 * Si può specificare il una data fino alla quale calcolare la rilevanza
 * Se sono passati degli ID (argomenti), sono interpretati come ID di atti e il calcolo è fatto solo per loro
 */
function run_opp_calcola_rilevanza_atti($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
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
  } else {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent();
    $data = date('Y-m-d');
  }

  $msg = sprintf("calcolo rilevanza atti - fino a: %10s\n", $data);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


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

  echo "memory usage: " . memory_get_usage( ) . "\n";

  $cnt = 0;
  while ($atti_rs->next())
  {
    $a = $atti_rs->getRow();

    $atto_id = $a['id'];
    $tipo_atto_id = $a['tipo_atto_id'];

    $cnt++;
    
    printf("%4d) %d ... ", $cnt, $atto_id);
    $indice = OppIndiceRilevanzaPeer::calcola_rilevanza_atto($atto_id, $tipo_atto_id, $data, $verbose);

    // inserimento o aggiornamento del valore in opp_politician_history_cache
    $cache_record = OppActHistoryCachePeer::retrieveByDataChiTipoChiId($data, 'A', $atto_id);
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

    $msg = sprintf(" %10d\n", memory_get_usage( ));
    echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
    
  }

  $msg = sprintf("%d atti elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


}


/**
 * Calcola o ri-calcola la rilevanza degli argomenti, come somma della rilevanza degli atti taggati
 * Si può specificare il una data fino alla quale calcolare la rilevanza
 * Se sono passati degli ID (argomenti), sono interpretati come ID di argomenti e il calcolo è fatto solo per loro
 */
function run_opp_calcola_rilevanza_tag($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
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
  } else {
    $legislatura_corrente = OppLegislaturaPeer::getCurrent();
    $data = date('Y-m-d');
  }


  $msg = sprintf("calcolo rilevanza tag - fino a: %10s\n", $data);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


  if (count($args) > 0)
  {
    $tags_ids = $args;
  } else {
    $tags_ids = TaggingPeer::getActiveTagsIdsData('OppAtto', $data);    
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";

  foreach ($tags_ids as $cnt => $tag_id) {

    printf("%4d) %d ... ", $cnt+1, $tag_id);
    $indice = OppIndiceRilevanzaPeer::calcola_rilevanza_tag($tag_id, $data, $verbose);

    // inserimento o aggiornamento del valore in opp_tag_history_cache
    $cache_record = OppTagHistoryCachePeer::retrieveByDataChiTipoChiId($data, 'S', $tag_id);
    if (!$cache_record) {
      $cache_record = new OppTagHistoryCache();
    }
    $cache_record->setLegislatura($legislatura_corrente);
    $cache_record->setChiTipo('S');
    $cache_record->setChiId($tag_id);
    $cache_record->setIndice($indice);
    $cache_record->setData($data);
    $cache_record->setUpdatedAt(date('Y-m-d H:i')); // forza riscrittura updated_at, per tenere traccia esecuzioni
    $cache_record->save();
    unset($cache_record);

    $msg = sprintf("%7.2f", $indice);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    $msg = sprintf(" %10d\n", memory_get_usage( ));
    echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  }

  $msg = sprintf("%d tag elaborati\n", $cnt+1);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


}


