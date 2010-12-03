<?php
/*
 * This file is part of the stlabTasks package.
 *
 * (c) 2010 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
?>
<?php
/**
 * @package    
 * @subpackage Task per estrarre testi e tagging degli atti 
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("generazione csv tags degli atti");
pake_task('stlab-genera-atti-tags-csv', 'project_exists');

pake_desc("generazione csv elenco tag");
pake_task('stlab-genera-tags-csv', 'project_exists');

pake_desc("generazione dei files di testo degli atti");
pake_task('stlab-genera-testi-atti', 'project_exists');

/**
 * Genera un elenco csv di atti con i loro tag (id)
 * ATTO_ID, N_TAG, TAG_ID_1, TAG_ID_2, ...
 */
function run_stlab_genera_atti_tags_csv($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  $file_path = sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . "stlab" . DIRECTORY_SEPARATOR . "atti_tags.csv";
  if (array_key_exists('file_path', $options)) {
    $file_path = strtolower($options['file_path']);
  }


  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();

  $msg = sprintf("generazione csv tag di ogni atto\n");
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $fh = fopen($file_path, 'w');

  $atti = OppAttoPeer::doSelect(new Criteria());
  $n_atti = count($atti);
  foreach ($atti as $cnt => $atto) {
    $tags_ids = $atto->getTagsIds();
    if (count($tags_ids)) {
      $row = sprintf("%d,%d,%s", $atto->getId(), count($tags_ids), implode(",", $tags_ids));
      printf("%5d/%5d: %s\n", $cnt, $n_atti, $row);
      fprintf($fh, "%s\n", $row);
    }
  }
  fclose($fh);

  $msg = sprintf("%d atti elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
}

/**
 * Genera l'elenco csv di valori e namespace dei tag
 * TAG_ID, TRIPLE_VALUE, TRIPLE_NAMESPACE
 */
function run_stlab_genera_tags_csv($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  $file_path = sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . "stlab" . DIRECTORY_SEPARATOR . "tags.csv";
  if (array_key_exists('file_path', $options)) {
    $file_path = strtolower($options['file_path']);
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();

  $msg = sprintf("generazione csv dei tags\n");
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $fh = fopen($file_path, 'w');

  $tags = TagPeer::doSelect(new Criteria());
  $n_tags = count($tags);
  foreach ($tags as $cnt => $tag) {
    $row = sprintf("%d,%s,%s", $tag->getId(), $tag->getTripleValue(), $tag->getTripleNamespace());
    printf("%5d/%5d: %s\n", $cnt, $n_tags, $row);
    fprintf($fh, "%s\n", $row);
  }
  fclose($fh);

  $msg = sprintf("%d tag elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));        
}


/**
 * Genera i files di testo degli atti
 * ATTO_ID_i.txt - i num progressivo del testo
 */
function run_stlab_genera_testi_atti($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  $files_path = sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . "stlab";
  if (array_key_exists('files_path', $options)) {
    $files_path = strtolower($options['files_path']);
  }

  $verbose = false;
  $offset = null;
  $limit = null;
  if (array_key_exists('verbose', $options)) {
    $verbose = true;
  }
  if (array_key_exists('offset', $options)) {
    $offset = $options['offset'];
  }
  if (array_key_exists('limit', $options)) {
    $limit = $options['limit'];
  }
  

  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();

  $msg = sprintf("generazione files dei testi degli atti\n");
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


  // creazione del file di archivio
  $zip = new ZipArchive;
  $zip_file_name = $files_path . DIRECTORY_SEPARATOR . "testi.zip";
  if (!file_exists($zip_file_name)) {
    $res = $zip->open($zip_file_name, ZIPARCHIVE::CREATE);
  } else {
    $res = $zip->open($zip_file_name);
  }

  if ($res !== TRUE) {
    throw new Exception("Impossibile creare l'archivio testi.zip: " . $res);
  }
  
  // set dei limiti
  $c = new Criteria();
  if (!is_null($limit)) {
    $c->setLimit($limit);
  }
  
  if (!is_null($offset)) {
    $c->setOffset($offset);
  }
  
  // estrazione atti
  $docs = OppDocumentoPeer::doSelect($c);

  $n_docs = count($docs);
  foreach ($docs as $cnt => $doc) {
    printf("%5d/%5d: ", $c->getOffset() + $cnt + 1, $c->getOffset() + $n_docs);
    
    // definizione nome nell'archivio (attoID_docID)
    $file_name = $doc->getAttoId() . "_" . $doc->getId() . ".txt";

    // aggiunta testo all'archivio
    $zip->addFromString($file_name, $doc->getTesto());
    
    printf(" %d_%d ok (%d)\n", $doc->getAttoId(), $doc->getId(), memory_get_usage());
  }
  
  // chiusura archivio e scrittura su file system
  $zip->close();


  $msg = sprintf("%d atti elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));        
  
}


