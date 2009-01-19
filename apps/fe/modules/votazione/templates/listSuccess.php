<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <?php include_partial('votazioneRightColumn') ?>  
    </div>
    <div class="W73_100 float-left">
      <?php include_partial('wiki') ?>  	  		

      <?php include_partial('filter',
                            array('tags_categories' => $all_tags_categories,
                                  'selected_type' => array_key_exists('type', $filters)?$filters['type']:0,                                
                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                  'selected_ramo' => array_key_exists('ramo', $filters)?$filters['ramo']:0,
                                  'selected_esito' => array_key_exists('esito', $filters)?$filters['esito']:0)) ?>

      <?php include_partial('sort') ?>      

      <?php include_partial('list', array('pager' => $pager)) ?>  
    </div>
    <div class="clear-both"></div>
  </div>
</div>