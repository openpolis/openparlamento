<?php
/*
 * This file is part of the Openpolis project
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Creates the initial wiki descriptions for Attos and Votaziones
 */
?>
<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

// clean all pages and content
nahoWikiPagePeer::doDeleteAll();
nahoWikiContentPeer::doDeleteAll();

// define all classes that needs descriptions and their prefix in the name field
$classes = array('OppAtto'      => 'atto',
                 'OppVotazione' => 'votazione');

$tot_cnt = 0;
foreach ($classes as $model => $name_prefix)
{
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
  

  // only select primary key fields
  $c->clearSelectColumns();
  foreach ($pks as $pk) 
    $c->addSelectColumn($pk->getFullyQualifiedName());
    
  // get raw records, without populating objects, in order to be faster and lighter
  $acts_rs = call_user_func_array(array($model.'Peer', 'doSelectRS'), array($c));    
  $cnt = 0;
  while ($acts_rs->next())
  {
    // retrieve all primary key values, to fully retrieve the object
    $pk_values = array(); $i=1;
    foreach ($pks as $pk)
    {
      $method = 'get' . ucfirst($pk->getType());
      $pk_values []= $acts_rs->$method($i++);
    }
      
    // fetch the object (needed to call the generateNews method)
    // then destroys it, in order to release memory
    $object = call_user_func_array(array($model.'Peer', 'retrieveByPK'), $pk_values);
    try{
      nahoWikiToolkit::add_wiki_description($object, $name_prefix,
                                            sfConfig::get('nahoWikiPlugin_default_description'), 
                                            "Creazione Automatica");      
    } catch (Exception $e) {
      echo "Exception: " . $e->getMessage() . "\n";
    }
    unset($object);
    
    // increment partial and total counters
    $cnt++;
    $tot_cnt++;
    
    if ($cnt % 100 == 0) echo $cnt . " ";
  }
  echo "\n$cnt objects of type $model imported\n";
}
echo "$tot_cnt total\n";