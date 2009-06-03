<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Import into sf_news_cache, starting from already populated tables.
 * Since this script cleans the sf_news_cache table, use with extreme care.
 * It can be used in order to re-build all the news.
 */
?>
<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

// uncomment to clean all news
echo "Removing all news ...\n";
NewsPeer::doDeleteAll();

// echo "Removing all taggings";
// $c = new Criteria();
// $c->add(NewsPeer::GENERATOR_MODEL, 'Tagging');
// NewsPeer::doDelete($c);

// define all news generators and the corresponding date fields (null = no field) for sorting purposes
$generators = array('OppCaricaHasAtto'    => OppCaricaHasAttoPeer::DATA,
                    'OppVotazioneHasAtto' => null,
                    'OppDocumento'        => OppDocumentoPeer::DATA,
                    'OppAttoHasIter'      => OppAttoHasIterPeer::DATA, 
                    'OppAttoHasSede'      => null,
                    'OppIntervento'       => OppInterventoPeer::DATA,
                    'OppAtto'             => OppAttoPeer::DATA_PRES,
                    'OppCaricaHasGruppo'  => OppCaricaHasGruppoPeer::DATA_INIZIO,
                    'OppCarica'           => OppCaricaPeer::DATA_INIZIO,
                    'Tagging'             => null,
                    );

// $generators = array('Tagging' => null);

$tot_cnt = 0;
foreach ($generators as $model => $date_field)
{
  echo "Processing model $model ";
  $c = new Criteria();
  
  // extract the number of items to process for the generator
  $n_todo = call_user_func_array(array($model.'Peer', 'doCount'), array($c));    
  echo "($n_todo) \n";
  
  // get table map and columns map for this generator
  $model_table = call_user_func($model.'Peer::getTableMap'); 
  $model_columns = $model_table->getColumns();
  
  // find and store primary keys
  $pks = array();
  foreach($model_columns as $column){
    if ($column->isPrimaryKey())
      $pks []= $column;
  }
  

  // process and insert news ordered by the date field (when defined)
  if ($date_field)
    $c->addAscendingOrderByColumn($date_field);
  
  // only select primary key fields
  $c->clearSelectColumns();
  foreach ($pks as $pk) 
    $c->addSelectColumn($pk->getFullyQualifiedName());
        
  // get raw records, without populating objects, in order to be faster and lighter
  $rs = call_user_func_array(array($model.'Peer', 'doSelectRS'), array($c));    
  $cnt = 0;
  while ($rs->next())
  {
    // retrieve all primary key values, to fully retrieve the object
    $pk_values = array(); $i=1;
    foreach ($pks as $pk)
    {
      $method = 'get' . ucfirst($pk->getType());
      $pk_values []= $rs->$method($i++);
    }
      
    // fetch the object (needed to call the generateNews method)
    // then destroys it, in order to release memory
    $object = call_user_func_array(array($model.'Peer', 'retrieveByPK'), $pk_values);
    try{
      // allow news_generation_skipping
      if (isset($object->skip_news_generation) && $object->skip_news_generation == true) return;

      // grouped news generation
      if (isset($object->generate_group_news) && $object->generate_group_news == true)
        $object->generateUnlessAlreadyHasGroupNews();        

      // simple news generation
      if (isset($object->priority_override) && $object->priority_override > 0)
        $object->generateNews($object->priority_override);
      else
        $object->generateNews();  
        
      // generates succNews news if the succ field is not null
      if ($object instanceof Oppatto && !is_null($object->getSucc()))
        $object->generateNews(null, true);

    } catch (Exception $e) {
      echo "Exception: " . $e->getMessage() . "\n";
    }
    unset($object);
    
    // increment partial and total counters
    $cnt++;
    $tot_cnt++;
    
    if ($cnt % 100 == 0) echo $cnt . " ";
  }
  echo "\n$cnt objects of type $model processed\n\n";
}
echo "$tot_cnt total\n";

