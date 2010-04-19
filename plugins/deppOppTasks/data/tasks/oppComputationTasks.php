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

/**
* Calcola o ri-calcola l'indice di attività.
* Si può specificare il ramo (camera, senato, tutti) e il periodo (legislatura[tutto], anno, mese, settimana)
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


  $settimana = '';
  $ramo = '';
  $verbose = false;
  $offset = null;
  $limit = null;
  if (array_key_exists('settimana', $options)) {
    $settimana = $options['settimana'];
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

  if ($settimana != '')
    $legislatura_corrente = OppLegislaturaPeer::getCurrent($settimana);
  else
    $legislatura_corrente = OppLegislaturaPeer::getCurrent();

  $msg = sprintf("calcolo indice di attività - settimana: %10s, ramo: %10s\n", $settimana?$settimana:'-', $ramo);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));
    
  $parlamentari = OppCaricaPeer::getParlamentariRamoSettimana($ramo, $settimana, $offset, $limit);
  echo "memory usage: " . memory_get_usage( ) . "\n";

  foreach ($parlamentari as $cnt => $parlamentare) {
    $politico = $parlamentare->getOppPolitico();
    $id = $parlamentare->getId();

    printf("%4d) %40s [%06d] ... ", $cnt, $politico, $id);
    $indice = calcola_indice_politico($id, $settimana, $verbose);

    // inserimento o aggiornamento del valore in opp_politician_history_cache
    $cache_record = OppPoliticianHistoryCachePeer::retrieveByLegislaturaChiTipoChiId($legislatura_corrente, 'P', $id);
    if (!$cache_record) {
      $cache_record = new OppPoliticianHistoryCache();
    }
    $cache_record->setLegislatura($legislatura_corrente);
    $cache_record->setChiTipo('P');
    $cache_record->setChiId($id);
    $cache_record->setIndice($indice);
    $cache_record->setUpdatedAt(time()); // forza riscrittura updated_at, per tenere traccia esecuzioni
    $cache_record->save();
    unset($cache_record);

    $msg = sprintf("%7.2f", $indice);
    echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));      

    $msg = sprintf(" %10d\n", memory_get_usage( ));
    echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  }

  
  $msg = sprintf("%d parlamentari elaborati\n", count($parlamentari));
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


}


function calcola_indice_politico($id, $settimana = '', $verbose = '')
{
  // fetch dell'oggetto OppCarica
  $carica = OppCaricaPeer::retrieveByPK($id);
  
  // estrae atti ed emendamenti firmati come Primo Firmatario, fino alla fine della settimana indagata
  if ($settimana == '') {
    $atti = $carica->getPresentedAttos();
    $emendamenti = $carica->getPresentedEmendamentos();
  } else {
    $atti = $carica->getPresentedAttos(date('Y-m-d', strtotime("+1 week", strtotime($settimana))));
    $emendamenti = $carica->getPresentedEmendamentos(date('Y-m-d', strtotime("+1 week", strtotime($settimana))));
  }

  $punteggio = 0.;
  
  // --- componente dell'indice dovuta agli atti ---
  if ($verbose)
    printf("\n  numero atti: %d\n", count($atti));
  foreach ($atti as $atto) {
    $punteggio += OppIndiceAttivitaPeer::calcolaIndiceAtto($carica, $atto, $settimana, $verbose);
  }

  // --- componente dell'indice dovuta agli emendamenti ---
  if ($verbose)
    printf("\n  numero emendamenti: %d\n", count($emendamenti));
  foreach ($emendamenti as $emendamento) {
    $punteggio += OppIndiceAttivitaPeer::calcolaIndiceEmendamento($carica, $emendamento, $settimana, $verbose);
  }
  
  return $punteggio;
}
