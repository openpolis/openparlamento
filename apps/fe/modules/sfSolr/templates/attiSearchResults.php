<?php use_helper('sfSolr', 'OppSolr', 'I18N', 'PagerNavigation') ?>

<?php include_partial('atto/tabs', array('current' => $type)) ?>

<div id="content" class="tabbed float-container">

  <div id="main">
    <div class="W25_100 float-right">
      <?php 
        echo include_partial('sfSolr/specialized_controls', 
                            array('query' => $query,
                                  'type'  => $type,
                                  'title' => $title));
      ?>

  	</div>

    <div class="W73_100 float-left">
      <?php echo include_partial('sfSolr/addAlert', array('query' => $query)); ?>

      <p style="margin: 10px 0; text-align: right; padding: 5px">Risultati <?php echo $start ?> - <?php echo $start + $rows - 1 ?> su 
         <?php echo $num ?> per <strong><?php echo $query ?></strong> <?php echo $title ?> (<?php echo $qTime ?>ms)</p>

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
              <?php include_search_result($result, $query,array('num_item'=>$num_item)) ?>
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

      <?php echo pager_navigation($pager, "@attiSearch?type=$type&query=$query") ?>


    </div>
  </div>

</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  <?php echo link_to($pages_names[$type], $pages_routes[$type]) ?> / 
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>
