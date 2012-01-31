<div class="row">
	<div class="twelvecol">
		
		<?php include_partial('tabs', array('current' => 'rilevanzaAtti')) ?>
		
	</div>
</div>

<div class="row">
	<div class="twelvecol">
		
		<?php include_partial('filtersAtti',
	                          array('date' => $all_dates,
	                                'tags_categories' => $all_tags_categories,
	                                'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),
	                                'selected_act_type' => array_key_exists('act_type', $filters)?$filters['act_type']:0,                                
	                                'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
	                                'selected_ramo' => array_key_exists('ramo', $filters)?$filters['ramo']:0,
	                                'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0,
	                                'selected_data' => array_key_exists('data', $filters)?$filters['data']:0)) ?>

	    <?php include_partial('rilevanzaAttiSort') ?>


	    <?php echo include_partial('default/listNotice', 
	                               array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

	    <?php include_partial('rilevanzaAttiList', array('pager' => $pager)) ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> / dati storici su indice attivit&agrave;
<?php end_slot() ?>
