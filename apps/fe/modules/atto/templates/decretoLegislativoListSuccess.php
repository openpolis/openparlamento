<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'decrleg')) ?>

<div class="row">
	<div class="ninecol">
		
		<?php include_partial('decretoLegislativoWiki') ?>

	      <?php include_partial('decretoLegislativoFilter',
	                            array('tags_categories' => $all_tags_categories,
	                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
	                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
	                                  'selected_act_type' => array_key_exists('act_type', $filters)?$filters['act_type']:0)) ?>

	      <?php //include_partial('decretoLegislativoSort') ?>

	      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

	      <?php include_partial('decretoLegislativoList', array('pager' => $pager)) ?>
	
	</div>
	<div class="threecol last">
		
		<!-- 
	      <p class="last-update">data di ultimo aggiornamento: <strong><?php echo $last_updated_item->getDataAgg('d-m-Y') ?></strong></p>			
	      -->

	      <?php 
	        echo include_partial('sfSolr/specialized_controls', 
	                            array('query' => $query, 
	                                  'type' => 'decrleg', 
	                                  'title' => 'nei decreti legislativi'));
	      ?>


	
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  decreti legislativi
<?php end_slot() ?>