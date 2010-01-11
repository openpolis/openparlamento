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
            <td>
              <div class="ico-type">
                <?php include_search_result_icon($result) ?>                
              </div>
            </td>
          
            <td class="<?php echo (fmod($num_item,2)!=0) ? 'odd' : 'even' ?>">                      
              <?php include_search_result($result, $query, array('num_item'=>$num_item)) ?>
            </td>
            
            <td>
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

<?php slot('search') ?>
  <?php include_search_controls($query) ?>
<?php end_slot() ?>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>



