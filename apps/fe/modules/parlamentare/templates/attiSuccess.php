<?php use_helper('Date', 'I18N') ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2><?php echo $ramo=='camera' ? 'On. ' : 'Sen. ' ?><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
			
	  <div class="W100_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'atti', 
	                                     'parlamentare_id' => $parlamentare->getId())); ?>
	                                     	
   		<p class="tools-container"><a class="ico-help" href="#">cosa sono</a></p>
   		<div style="display: none;" class="help-box float-container">
   			<div class="inner float-container">

   				<a class="ico-close" href="#">chiudi</a><h5>cosa sono ?</h5>
   				<p>In questa pagina trovi tutti gli atti presentati, co-firmati e di cui &egrave; relatore il parlamentare</p>
   			</div>
   		</div>
 
      <?php include_partial('attiFilter',
                            array('tags_categories' => $all_tags_categories,
                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                  'selected_act_type' => array_key_exists('act_type', $filters)?$filters['act_type']:0,                                
                                  'selected_act_firma' => array_key_exists('act_firma', $filters)?$filters['act_firma']:0,
                                  'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

      <?php include_partial('attiSort', array('parlamentare_id' => $parlamentare->getId())) ?>

      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults(),
                                                             'route' => '@parlamentare_atti?id='.$parlamentare->getId())); ?>

      <?php include_partial('attiList', 
                            array('pager' => $pager, 'parlamentare_id' => $parlamentare->getId())) ?>


	  </div>


    <div class="clear-both"/>			
    </div>
		
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  
  <?php if($ramo =='senato' ): ?>
    <?php echo link_to('senatori', '@parlamentari?ramo=senato') ?> /
    Sen. 
  <?php else: ?>
    <?php echo link_to('deputati', '@parlamentari?ramo=camera') ?> /
    On.
  <?php endif; ?>
  <?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?>
<?php end_slot() ?>
