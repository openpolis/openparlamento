<?php
/*
 * This file is part of the deppOppTasks package.
 *
 * (c) 2010 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Questi task sono DEPRECATI. In sostituzione, usare i task:
 * - opp-build-cache-politici --ramo=parlamento (calcola anche le presenze e i ribelli)
 * - opp-build-cache-atti
 * - opp-build-cache-tag
 */
?>
<?php
/**
 * @package    
 * @subpackage Task per computare dati (presenze, indice attività)
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("calcola il nuovo indice di attività");
pake_task('opp-calcola-nuovo-indice', 'project_exists');

pake_desc("calcola la rilevanza per gli atti");
pake_task('opp-calcola-rilevanza-atti', 'project_exists');

pake_desc("calcola la rilevanza per gli argomenti");
pake_task('opp-calcola-rilevanza-tag', 'project_exists');

pake_desc("calcola e mostra interesse di parlamentari su argomenti a una data");
pake_task('opp-get-storico-interesse', 'project_exists');

pake_desc("mostra dettaglio posizionamento parlamentare rispetto a utente su argomenti");
pake_task('opp-get-posizionamento', 'project_exists');


/**
 * Calcola o ri-calcola l'indice di attività.
 * Si può specificare il ramo (camera, senato, governo, tutti) e la data
 * Se sono passati degli ID (argomenti), sono interpretati come ID di politici e il calcolo è fatto solo per loro
 */
function run_opp_get_posizionamento($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();

  $ramo = '';
  if (array_key_exists('ramo', $options)) {
    $ramo = strtolower($options['ramo']);
  }

  $verbose = false;
  if (array_key_exists('verbose', $options)) {
    $verbose = true;
  }

  $tags_ids = array();
  if (array_key_exists('tags', $options)) {
    $tags_ids = explode(",", $options['tags']);
  }

  $user_id = 0;
  if (array_key_exists('user', $options)) {
    $user_id = $options['user'];
  }

  $tags_names = array();
  foreach ($tags_ids as $tag_id) {
    $tag = TagPeer::retrieveByPK($tag_id);
    $tags_names []= $tag->getTripleValue();
  }
  
  
  $msg = sprintf("calcolo posizionamento per i tag: %s\n", implode(",", $tags_names));
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  if (count($args) > 0)
  {
    try {
      $parlamentari_rs = OppCaricaPeer::getRSFromIDArray($args);            
    } catch (Exception $e) {
      throw new Exception("Specificare degli ID validi. \n" . $e);
    }
  } else {
    throw new Exception("Specificare uno o più ID di carica dei parlamentari. \n" . $e);
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
    $carica_id = $p['id'];
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
    printf("%4d) %40s [%06d] ... ", $cnt, $politico_stringa, $carica_id);

    $punteggio = OppCaricaPeer::getPosizionePoliticoOggettiVotatiPerArgomenti($carica_id, $tags_ids, $user_id, true);

    $msg = sprintf("  Punteggio totale: %7.2f", $punteggio);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
    echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  }

  
  $msg = sprintf("%d parlamentari elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));
}



/**
 * Calcola o ri-calcola l'indice di attività.
 * Si può specificare il ramo (camera, senato, governo, tutti) e la data
 * Se sono passati degli ID (argomenti), sono interpretati come ID di politici e il calcolo è fatto solo per loro
 */
function run_opp_calcola_nuovo_indice($task, $args, $options)
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
  $start_time = time();

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
    $data_lookup = OppPoliticianHistoryCachePeer::fetchLastData('N');
  }


  $msg = sprintf("calcolo indice di attività - data:   %10s, ramo: %10s\n", $data?$data:'-', $ramo);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  if (count($args) > 0)
  {
    try {
      $parlamentari_rs = OppCaricaPeer::getRSFromIDArray($args);            
    } catch (Exception $e) {
      throw new Exception("Specificare degli ID validi. \n" . $e);
    }
  } else {
    $parlamentari_rs = OppCaricaPeer::getParlamentariRamoDataRS($ramo, $legislatura_corrente, $data, $offset, $limit);    
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
    $indice = OppIndiceAttivitaPeer::calcola_indice_politico($id, $legislatura_corrente, $data, $verbose, $atti_ids, $emendamenti_ids);

    // inserimento o aggiornamento del valore in opp_politician_history_cache
    // uso N come ChiTipo, perché P è preso per il vecchio indice.
    // una volta fatta la sostituzione, la scrittura qui è ridondante
    $cache_record = OppPoliticianHistoryCachePeer::retrieveByDataChiTipoChiIdRamo($data_lookup, 'N', $id, $ramo);
    if ($cache_record === null) {
      $cache_record = new OppPoliticianHistoryCache();
    }
    $cache_record->setLegislatura($legislatura_corrente);
    $cache_record->setChiTipo('N');
    $cache_record->setChiId($id);
    $cache_record->setRamo($ramo);
    $cache_record->setIndice($indice);
    $cache_record->setData($data);
    $cache_record->setNumero(1);
    $cache_record->setUpdatedAt(date('Y-m-d H:i')); // forza riscrittura updated_at, per tenere traccia esecuzioni
    $cache_record->save();
    unset($cache_record);

    $msg = sprintf("%7.2f", $indice);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
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

    $atto = OppAttoPeer::retrieveByPK($atto_id);
    $priorita = is_null($atto->getPriorityValue()) ? 1 : $atto->getPriorityValue();

    $cnt++;

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
    $cache_record->setPriorita($priorita);
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
    _loader();
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";

  $data = '';
  $verbose = false;
  $offset = null;
  $limit = null;
  
  $start_time = time();
  
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
    $data_lookup = OppTagHistoryCachePeer::fetchLastData();
  }


  $msg = sprintf("calcolo rilevanza tag - fino a: %10s\n", $data);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


  if (count($args) > 0)
  {
    $tags_ids = $args;
  } else {
    $tags_ids = TaggingPeer::getActiveTagsIdsData('OppAtto', $data);    
  }

  $n_tags = count($tags_ids);
  
  echo "memory usage: " . memory_get_usage( ) . "\n";

  foreach ($tags_ids as $cnt => $tag_id) {

    printf("%5d/%6d) %40s %6d ... ", $cnt+1, $n_tags, TagPeer::retrieveByPK($tag_id), $tag_id);
    $indice = OppIndiceRilevanzaPeer::calcola_rilevanza_tag($tag_id, $data, $verbose);

    // inserimento o aggiornamento del valore in opp_tag_history_cache
    $cache_record = OppTagHistoryCachePeer::retrieveByDataChiTipoChiId($data_lookup, 'S', $tag_id);
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

    $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
    echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  }

  $msg = sprintf("%d tag elaborati\n", $cnt+1);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


}


/**
 * Calcola e mostra lo storico dell'interesse dei politici su determinati argomenti
 * Si deve specificare gli ID dei politici e l'ID degli argomenti
 */
function run_opp_get_storico_interesse($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();

  // parameteri obbligatori
  if (array_key_exists('tags', $options)) {
    $tags = $options['tags'];
    $tags_ids = split(",", $tags);
  } else
    throw new Exception("E' obbligatorio specificare i tags, ad esempio: 845,3487,123");

  // specificare la data fino alla quale estrarre lo storico
  $data = '';
  if (array_key_exists('data', $options)) {
    // verifica che si tratti di una data (evita sql-injection)
    $data = date('Y-m-d', strtotime($options['data']));
    $data_condition = " data < $data ";
  } else 
    $data_condition = null;


  $msg = sprintf("calcolo storico interesse su tag: %s\n", $tags);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  if (count($args) > 0)
  {
    try {
      $parlamentari_rs = OppCaricaPeer::getRSFromIDArray($args);            
    } catch (Exception $e) {
      throw new Exception("Specificare dei carica_id validi. \n" . $e);
    }
  } else {
    throw new Exception("Specificare almeno un carica_id valido. \n" . $e);
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";

  $cnt = 0;
  while ($parlamentari_rs->next())
  {
    $cnt++;
    $p = $parlamentari_rs->getRow();

    $msg = sprintf("%d %s %s\n", $cnt, 
                   $p['tipo_carica_id'] == '1' ? 'On.' : 'Sen.', 
                   ucfirst($p['nome']) .' '. strtoupper($p['cognome']));
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

    $storico = OppCaricaPeer::getStoricoInteressePoliticoArgomenti($p['id'], $tags_ids, $data_condition);
    foreach ($storico as $key => $value) {
      $msg = sprintf("\t %s => %7.2f\n", $key, round($value, 2));
      echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));
    }
    
    
  }

  
  $msg = sprintf("%d parlamentari elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));
}
