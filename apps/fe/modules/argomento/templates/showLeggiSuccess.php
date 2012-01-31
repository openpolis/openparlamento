<?php use_helper('Javascript', 'Date', 'I18N') ?>

<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Argomento: <?php echo strtolower($argomento->getTripleValue()) ?></h2></li>
</ul>

<div class="row">
	<div class="twelvecol">
		
		<?php echo include_partial('secondlevelmenu', 
                               array('current' => 'leggi', 
                                      'triple_value' => $triple_value)); ?>
                                     	
 		<p class="tools-container"><a class="ico-help" href="#">cosa trovo in questa pagina</a></p>
 		<div style="display: none;" class="help-box float-container">
 			<div class="inner float-container">

 				<a class="ico-close" href="#">chiudi</a><h5>cosa trovo in questa pagina ?</h5>
 				<p>In questa pagina trovi la lista dei disegni e decreti legge relativi all'argomento</p>
 			</div>
 		</div>

		<?php include_partial('leggiFilter',
		                      array('active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
		                            'selected_act_leggi_type' => array_key_exists('act_leggi_type', $filters)?$filters['act_leggi_type']:0,                                
		                            'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:0,
		                            'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

		<?php include_partial('attiSort', array('session_namespace' => 'argomento_leggi/sort', 
		                                        'triple_value' => $triple_value,
		                                        'route' => '@argomento_leggi')) ?>

		<?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults(),
		                                                       'route' => '@argomento_leggi?triple_value='.$triple_value)); ?>

		<?php include_partial('leggiList', 
		                      array('pager' => $pager, 'triple_value' => $triple_value)) ?>
		
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('argomenti', '@argomenti') ?> /
  <?php echo strtolower($argomento->getTripleValue()) ?>
<?php end_slot() ?>
