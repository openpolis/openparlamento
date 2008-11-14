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
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

// uncomment to clean all news
NewsPeer::doDeleteAll();

// define all news generators and the corresponding date fields (null = no field) for sorting purposes
$generators = array(//'OppCaricaHasAtto'    => OppCaricaHasAttoPeer::DATA,
                    'OppVotazioneHasAtto' => null,
                    //'OppDocumento'        => OppDocumentoPeer::DATA,
                    'OppAttoHasIter'      => OppAttoHasIterPeer::DATA, 
                    //'OppAttoHasSede'      => null,
                    //'OppIntervento'       => OppInterventoPeer::DATA,
                    //'OppAtto'             => OppAttoPeer::DATA_PRES,
                    'OppCaricaHasGruppo'  => OppCaricaHasGruppoPeer::DATA_INIZIO,
                    'OppCarica'           => OppCaricaPeer::DATA_INIZIO,
                    );

$tot_cnt = 0;
foreach ($generators as $model => $date_field)
{
  echo "Importing from $model ";
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
    $act = call_user_func_array(array($model.'Peer', 'retrieveByPK'), $pk_values);
    try{
      // exceptions
      if ($model == 'OppVotazioneHasAtto' && $act->getOppVotazione()->getFinale()==1 ||
          $model == 'OppAttoHasIter' && $act->getOppIter()->getConcluso()==1 && $act->getOppIter()->getFase()!='CONCLUSO')
        $act->generateNews(1);
      else
        $act->generateNews();      
    } catch (Exception $e) {
      echo "Exception: " . $e->getMessage() . "\n";
    }
    unset($act);
    
    // increment partial and total counters
    $cnt++;
    $tot_cnt++;
    
    if ($cnt % 100 == 0) echo $cnt . " ";
  }
  echo "\n$cnt objects of type $model imported\n";
}
echo "$tot_cnt total\n";

