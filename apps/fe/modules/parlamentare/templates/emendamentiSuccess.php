<?php use_helper('Date', 'I18N') ?>
<?php
slot('canonical_link');
echo "\n<link rel=\"canonical\" href=\"". url_for('@parlamentare_emendamenti?'. $parlamentare->getUrlParams() , true) ."\" />";
end_slot();
?>

<div class="row" id="tabs-container">
    <ul class="float-container tools-container" id="content-tabs">
    	<li class="current"><h2><?php echo $ramo=='camera' ? 'On. ' : 'Sen. ' ?><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
    </ul>
</div>

<div class="row">
	<div class="twelvecol">
		
		<?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'emendamenti', 
	                                     'parlamentare_id' => $parlamentare->getId(),
	                                     'parlamentare_slug' => $parlamentare->getSlug())); ?>
	                                     	
   		<p class="tools-container"><a class="ico-help" href="#">cosa trovo in questa pagina</a></p>
   		<div style="display: none;" class="help-box float-container">
   			<div class="inner float-container">

   				<a class="ico-close" href="#">chiudi</a><h5>cosa trovo in questa pagina ?</h5>
   				<p>In questa pagina trovi tutti gli emendamenti presentati e co-firmati dal parlamentare</p>
   			</div>
   		</div>
   		
   		
   		<?php include_partial('emendamentiFilter',
                            array('ddls_collegati' => $ddls_collegati,
                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                                                        
                                  'selected_ddls_collegati' => array_key_exists('ddls_collegati', $filters)?$filters['ddls_collegati']:0,
                                  'selected_act_firma' => array_key_exists('act_firma', $filters)?$filters['act_firma']:0)) ?>
 
      
      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults(),'route' => '@parlamentare_emendamenti?'.$parlamentare->getUrlParams())); ?>

      <?php include_partial('emendamentiList', 
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
