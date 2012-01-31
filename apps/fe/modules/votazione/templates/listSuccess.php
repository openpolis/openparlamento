<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'voti_tutti')) ?>

<div class="row">
	<div class="ninecol">
		
		<?php include_partial('wiki') ?>  	  		

	      <?php include_partial('filter',
	                            array('tags_categories' => $all_tags_categories,
	                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
	                                  'selected_type' => array_key_exists('type', $filters)?$filters['type']:0,                                
	                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
	                                  'selected_ramo' => array_key_exists('ramo', $filters)?$filters['ramo']:0,
	                                  'selected_esito' => array_key_exists('esito', $filters)?$filters['esito']:0)) ?>

	      <?php include_partial('sort') ?>      

	      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

	      <?php include_partial('list', array('pager' => $pager)) ?>
		
	</div>
	<div class="threecol last">
		
		<?php include_partial('votazioneRightColumn', array('query' => $query)) ?>  
	       <p align=center>
	      <?php echo link_to(image_tag('/images/banner_grafico_230x80.png'),'/grafico_distanze/votes_16_C') ?>
	      </p>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  tutte le votazioni
<?php end_slot() ?>
