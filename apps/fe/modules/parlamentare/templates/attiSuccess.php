<?php use_helper('Date', 'I18N') ?>
<?php
slot('canonical_link');
echo "\n<link rel=\"canonical\" href=\"". url_for('@parlamentare_atti?'. $parlamentare->getUrlParams() , true) ."\" />";
end_slot();
$ramo = isset($ramo) ? $ramo : '';
?>

<div class="row" id="tabs-container">
    <ul class="float-container tools-container" id="content-tabs">
    	<li class="current"><h2><?php echo $ramo ? ($ramo=='camera' ? 'On. ' : 'Sen. ') : '' ?><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
    </ul>
</div>

<div class="row">
	<div class="twelvecol">
		
		<?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'atti', 
	                                    'tecnico' => $ramo == '',
	                                     'parlamentare_id' => $parlamentare->getId(),
	                                     'parlamentare_slug' => $parlamentare->getSlug())); ?>
	                                     	
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

      <?php include_partial('attiSort', array('parlamentare_id' => $parlamentare->getId(), 'parlamentare_slug' => $parlamentare->getSlug())) ?>

      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults(),
                                                             'route' => '@parlamentare_atti?id='.$parlamentare->getId().'&slug='.$parlamentare->getSlug())); ?>

      <?php include_partial('attiList', 
                            array('pager' => $pager, 'parlamentare_id' => $parlamentare->getId(), 'parlamentare_slug' => $parlamentare->getSlug() )) ?>
		
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
