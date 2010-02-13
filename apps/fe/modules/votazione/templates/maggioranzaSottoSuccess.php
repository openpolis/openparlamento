<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'maggioranza_sotto')) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <?php include_partial('votazioneRightColumn', array('query' => $query)) ?>  
       <p align=center>
      <?php echo link_to(image_tag('/images/banner_grafico_230x80.png'),'/grafico_distanze/votes_16_C') ?>
      </p>
    </div>
    <div class="W73_100 float-left">
      <?php include_partial('wikiMaggioranzaSotto') ?>  	  
      
      
      <h6 style="padding:10px 0 5px 0;">In questa legislatura la maggioranza di governo &egrave; stata battuta in <?php echo $pager->getNbResults() ?> votazioni elettroniche d'aula di Camera e Senato.</h6>		
      
      <?php include_partial('filter',
                            array('tags_categories' => $all_tags_categories,
                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
                                  'selected_type' => array_key_exists('type', $filters)?$filters['type']:0,                                
                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                  'selected_ramo' => array_key_exists('ramo', $filters)?$filters['ramo']:0,
                                  'selected_esito' => array_key_exists('esito', $filters)?$filters['esito']:0)) ?>

      <?php //include_partial('sort') ?>      
      

      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

      <?php include_partial('maggioranzaSotto', array('pager' => $pager)) ?>  
    </div>
    <div class="clear-both"></div>
  </div>
</div>
<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  voti con maggioranza battuta
<?php end_slot() ?>