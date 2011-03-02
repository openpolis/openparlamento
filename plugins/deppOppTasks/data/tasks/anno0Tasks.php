<?php
/*
 * This file is part of the anno0Tasks package.
 *
 * (c) 2011 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * @package    
 * @subpackage Task per estrarre dati per anno0
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("estrae atti più rilevanti per determinati argomenti");
pake_task('a0-get-main-acts-for-tags', 'project_exists');


/**
 * estrae gli N atti più rilevanti per determinati argomenti (tag)
 */
function run_a0_get_main_acts_for_tags($task, $args, $options)
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

  $n = 1;
  if (array_key_exists('n', $options)) {
    $n = $options['n'];
  }
  if (!is_int($n) || $n < 1)
    throw new Exception("il numero di atti deve essere un intero\n");
    
  if (count($args) > 0)
  {
    $argomenti = array();
    foreach ($args as $cnt => $arg) {
      $id = TagPeer::getIdFromTagValue($arg);
      $xml_url = sprintf("http://parlamento.openpolis.it/xml/indici/tag/%d.xml", $id);
      $xsl_file = SF_ROOT_DIR . "/web/xml/indici/xslt/tagActsSorter.xslt";
      printf("Argomento %s:\n", $arg, $id);
      getImportantActs($xml_url, $xsl_file, $n);
      print "\n";
    }
  }

  $start_time = time();

  $msg = sprintf("end time: %s\n", date('H:i:s'));
  echo $msg;

  $msg = sprintf("memory usage: %10d\n", memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
  
}


function getImportantActs($xml_url, $xsl_filename, $n_nodes)
{
  try
  {
    // read the xml from url
    $xmldoc = new DomDocument();
    $xmldoc->load($xml_url);

    // read xslt file
    $xsldoc = new DomDocument();
    $xsldoc->load($xsl_filename);
    
    $xsl = new XSLTProcessor();
    $xsl->importStyleSheet($xsldoc);
    
    // trasforma XML secondo l'XSLT ed estrae il contenuto del div
    $transformed_xml = new SimpleXMLElement($xsl->transformToXML($xmldoc));
    $nodes = $transformed_xml->children();
    
    // write values to screen
    $cnt = 0;
    foreach ($nodes as $node) {
      $cnt ++;
      $atto = OppAttoPeer::retrieveByPK($node['atto_id']);
      printf("\t%d. %s => %f\n", $cnt, $atto->getTitoloCompleto(), $node['totale']);
      if ($cnt > $n_nodes) break;
    }

  } catch (Exception $e) {
    printf("Errore durante la scrittura del file: %s\n", $e->getMessage());      
  }
}

