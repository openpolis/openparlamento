<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2009 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For each record in opp_votazione_has_atto and opp_intervento, 
 * call the generateUnlessAlreadyHasGroupNews method.
 * This has the effect of updating the sf_news_cache.
 *
 */
?>
<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$model = 'OppCaricaHasAtto';
$date_field = OppCaricaHasAttoPeer::DATA;

echo "Processing $model ";
$c = new Criteria();

// extract the number of items to process for the generator
$n_todo = call_user_func_array(array($model.'Peer', 'doCount'), array($c));    
echo "($n_todo) ";

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
$objects_rs = call_user_func_array(array($model.'Peer', 'doSelectRS'), array($c));    
$cnt = 0;
$added = 0;
while ($objects_rs->next())
{
  // retrieve all primary key values, to fully retrieve the object
  $pk_values = array(); $i=1;
  foreach ($pks as $pk)
  {
    $method = 'get' . ucfirst($pk->getType());
    $pk_values []= $objects_rs->$method($i++);
  }
    
  // fetch the object (needed to call the generateNews method)
  // then destroys it, in order to release memory
  $object = call_user_func_array(array($model.'Peer', 'retrieveByPK'), $pk_values);
  if ($object->getTipo() == 'R' || $object->getData() > $object->getOppAtto()->getDataPres())
  {
    try{
      $added += $object->generateNews();
    } catch (Exception $e) {
      echo "Exception: " . $e->getMessage() . "\n";
    }    
  } else {
    try {
      $added += $object->generateNewsForPolitico();
    } catch (Exception $e) {
      echo "Exception: " . $e->getMessage() . "\n";
    }
  }
  unset($object);
  
  // increment total counters
  $cnt++;
  
  if ($cnt % 100 == 0) echo $added . "/" . $cnt . " ";
}
echo "\n$added news of type $model / $cnt cached\n";


