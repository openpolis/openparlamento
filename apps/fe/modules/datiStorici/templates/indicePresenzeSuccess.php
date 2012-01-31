<?php include_partial('tabs', array('current' => 'indicepresenze')) ?>

<div class="row">
	
	<div class="twelvecol">
		
		<a name="top"></a>
		<?php include_partial('filters',
	                          array('date' => $all_dates,
	                                'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),
	                                'selected_ramo' => array_key_exists('ramo', $filters)?$filters['ramo']:0,
	                                'selected_data' => array_key_exists('data', $filters)?$filters['data']:0)) ?>

	    <?php include_partial('indicePresenzeSort') ?>


	    <?php echo include_partial('default/listNotice', 
	                               array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

	    <?php include_partial('indicePresenzeList', array('pager' => $pager, 'date' => $date)) ?>

	    <div style="clear: both; text-align: center">
	      <?php echo link_to('scarica classifica completa in formato CSV (con filtri)', '@dati_storici_indice_presenze_export') ?>
	    </div>
		
	</div>
	
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> / dati storici su indice attivit&agrave;
<?php end_slot() ?>

