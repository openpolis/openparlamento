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
 * @subpackage Task per estrarre testi e tagging degli atti in formato adatto all'nltk
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("generazione file con elenco categorie per ogni atto");
pake_task('nltk-genera-categorie', 'project_exists');

pake_desc("generazione dei files di testo degli atti, divisi in training e test");
pake_task('nltk-genera-files', 'project_exists');

/**
 * Genera un elenco di atti con i loro tag (i nomi)
 * (training|dev|test)/ATTO_ID TAG_1, TAG_2, TAG_3, ...
 * il nome della dir è specificato nelle opzioni, una dir per volta
 */
function run_nltk_genera_categorie($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  $act_types = array();
  $prefix = null; // usato per differenziare training, test e dev, è aggiunto prima dell'id
  $offset = null;
  $limit = null;
  
  if (array_key_exists('offset', $options))
    $offset = $options['offset'];
  if (array_key_exists('limit', $options))
    $limit = $options['limit'];
  if (array_key_exists('types', $options))
    $act_types = explode(",", $options['types']);
  if (array_key_exists('prefix', $options))
    $prefix = strtolower($options['prefix']);


  if (count($args) > 0)
  {
    try {
      $atti_rs = OppAttoPeer::getRSFromIDArray($args);            
    } catch (Exception $e) {
      throw new Exception("Specificare degli ID validi. \n" . $e);
    }
  } else {
    $atti_rs = OppAttoPeer::getAttiTipoRS($act_types, $offset, $limit);    
  }


  // loop principale
  $n_atti = $atti_rs->getRecordCount();
  $cnt = 0;
  while ($atti_rs->next())
  {
    $a = $atti_rs->getRow();
    $atto_id = $a['id'];
    $tipo_atto_id = $a['tipo_atto_id'];

    $atto = OppAttoPeer::retrieveByPK($atto_id);
    $tags = $atto->getTags(array('is_triple' => true, 'return' => 'value', 'serialized' => true));
    if ($tags) {
      foreach ($tags_ar = explode(",", $tags) as $cnt => $tag) {
        $tags_ar[$cnt] = '"'.trim($tag).'"';
      }      
      unset($tag);
      
      $row = sprintf("%d,%s", $atto->getId(), implode(',', $tags_ar));
      if (is_null($prefix)) {
        printf("%s", $row);
      } else {
        printf("%s/%s", $prefix, $row);
      }
      if (count($args) > 1)
      {
        print("\n");
      }
    }

    unset($atto);
    
    $cnt++;
  }

}


/**
 * Genera i files di testo degli atti
 * $prefix/$atto_id
 */
function run_nltk_genera_files($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  $files_path = sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . "nltk";
  $act_types = array();
  $prefix = null; // usato per differenziare training, test e dev, è aggiunto prima dell'id
  $offset = null;
  $limit = null;
  
  if (array_key_exists('offset', $options))
    $offset = $options['offset'];
  if (array_key_exists('limit', $options))
    $limit = $options['limit'];
  if (array_key_exists('path', $options))
    $files_path = strtolower($options['path']);
  if (array_key_exists('types', $options))
    $act_types = explode(",", $options['types']);
  if (array_key_exists('prefix', $options))
  {
    $prefix = strtolower($options['prefix']);
  }

  if (count($args) > 0)
  {
    try {
      $atti_rs = OppAttoPeer::getRSFromIDArray($args);            
    } catch (Exception $e) {
      throw new Exception("Specificare degli ID validi. \n" . $e);
    }
  } else {
    $atti_rs = OppAttoPeer::getAttiTipoRS($act_types, $offset, $limit);    
  }
  

  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();

  $msg = sprintf("generazione files dei testi degli atti\n");
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));


  // creazione del file di archivio
  $zip = new ZipArchive;
  $zip_file_name = sprintf("%s/testi.zip", $files_path);
  if (!file_exists($zip_file_name)) {
    $res = $zip->open($zip_file_name, ZIPARCHIVE::CREATE);
  } else {
    $res = $zip->open($zip_file_name);
  }
  
  echo $zip_file_name;

  if ($res !== TRUE) {
    throw new Exception("Impossibile creare l'archivio testi.zip: " . $res);
  }
  
  // loop principale
  $n_atti = $atti_rs->getRecordCount();
  $cnt = 0;
  while ($atti_rs->next())
  {
    $a = $atti_rs->getRow();
    $atto_id = $a['id'];
    $tipo_atto_id = $a['tipo_atto_id'];

    $atto = OppAttoPeer::retrieveByPK($atto_id);
    if ($n_docs = $atto->countOppDocumentos()) 
    {
      $docs = $atto->getOppDocumentos();

      // definizione nome nell'archivio (attoID_docID)
      $file_name = $atto_id;

      // pathc di tutti i testi dei doc relativi all'atto
      $atto_txt = "";
      foreach ($docs as $doc) {
        $atto_txt .= $doc->getTesto();
      }
      
      unset($docs);

      // aggiunta testo all'archivio zip
      $zip->addFromString($file_name, $atto_txt);

    }
    printf(" %d %d docs - ok (%d)\n", $atto_id, $n_docs, memory_get_usage());
    
    unset($atto);
    $cnt++;

  }

  
  // chiusura archivio e scrittura su file system
  $zip->close();


  $msg = sprintf("%d atti elaborati\n", $cnt);
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));        
  
}


