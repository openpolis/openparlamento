<?php 
/** 
 * @package sfSolrPlugin
 * @subpackage Module
 * @author     Guglielmo Celata <g.celata@depp.it>
 */
?>

<?php use_helper('sfSolr', 'OppSolr', 'I18N', 'PagerNavigation') ?>

<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Risultati della ricerca per <em><?php echo $query ?></em></h2></li>
</ul>


<div class="tabbed float-container" id="content">
  <div id="main">
    <div class="W100_100 float-left">
      <?php echo include_partial('sfSolr/addAlert', array('query' => $query)); ?>
      
      <!-- filtri a faccette per data e per tipo di risultato 
      <div style="float:left; width: 19%; padding: 1em; padding-right: 0.3em; border-right: 1px dotted gray; margin-top: 3em; min-height: 500px;">
        <h3>Filtra per data</h3>
        <ul>
          <li>Questa settimana</li>
          <li>Questo mese</li>
          <li>Quest'anno</li>
        </ul>
        
      </div>
      -->

      <!-- risultati -->
      <div style="float:right; width: 100%">
        <p style="margin: 10px 0; text-align: right; padding: 5px">
          Risultati <?php echo $start ?> - <?php echo $start + $rows - 1 ?> su 
          <?php echo $num ?> per <strong><?php echo $query ?></strong> 
          (<?php echo $qTime ?>ms)
        </p> 


        <table class="search-results-table">
        <?php $num_item=0 ?>

          <?php foreach ($pager->getResults() as $result): ?>
            <?php $num_item=$num_item+1 ?>
            <tr>
              <td class="ico">
                <div class="ico-type">
                  <?php include_search_result_icon($result) ?>                
                </div>
              </td>

              <td class="text <?php echo (fmod($num_item,2)!=0) ? 'odd' : 'even' ?>">                      
                <?php include_search_result($result, $query, array('num_item'=>$num_item)) ?>
              </td>

              <td class="score">
                <div class="results-meter">
                  <div class="results-meter-value"><?php echo $result->getScore() ?>%</div>
                  <div class="results-meter-scale">
                    <div style="width: <?php echo $result->getScore() ?>%;" class="results-meter-bar"> </div>
                  </div>
               </div>
              </td>

            </tr>
          <?php endforeach ?>
        </table>
        <?php echo pager_navigation($pager, "@sf_solr_search_results?query=$query") ?>
        
      </div>
      

    </div>
  </div>
</div>

<?php slot('search') ?>
  <?php include_search_controls($query) ?>
<?php end_slot() ?>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>



