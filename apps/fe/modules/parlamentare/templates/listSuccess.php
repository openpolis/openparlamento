<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs',array('ramo' => $sf_params->get('ramo'),'gruppi'=> false)) ?>

<div class="row">
	<div class="twelvecol">
		
		<?php echo include_partial('secondLevelMenuParlamentari', 
	                               array('current' => 'lista',
	                               'ramo' => $sf_params->get('ramo'))); ?>
		
	</div>
</div>

<div class="row">
	<div class="ninecol">
		<?php include_partial('wiki') ?>       

	      <?php include_partial('filter',
	                            array('groups' => $all_groups, 'constituencies' => $all_constituencies,
	                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
	                                  'selected_group' => array_key_exists('group', $filters)?$filters['group']:0,                                
	                                  'selected_const' => array_key_exists('const', $filters)?$filters['const']:0)) ?>


	      <?php include_partial('sort') ?>   

	      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $n_parlamentari, 'route' => '@parlamentari?ramo='.$sf_params->get('ramo'))); ?>
		
	</div>
	<div class="threecol last"></div>
</div>

<div class="row">
	<div class="twelvecol">
		
		<?php include_partial('list', 
	                          array('parlamentari' => $parlamentari, 
	                                'numero_parlamentari' => $numero_parlamentari,
	                                'presidenti_ids' => OppPoliticoPeer::getPresidentiCamereIds(),
	                                'membri_governo_ids' => OppPoliticoPeer::getMembriGovernoIds())) ?>
		
	</div>
</div>


<div class="row">
	
	<div class="twelvecol">
		
		<a name="decaduti"></a>
		<h5 class="subsection">variazioni nella legislatura:</h5>  
		  <?php include_partial('list', array('parlamentari' => $parlamentari_decaduti, 'numero_parlamentari' => $numero_parlamentari)) ?>
		
	</div>
	
</div>


<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  
  <?php if($sf_params->get('ramo') && $sf_params->get('ramo')=='senato' ): ?>
    senatori
  <?php else: ?>
    deputati
  <?php endif; ?>
<?php end_slot() ?>

