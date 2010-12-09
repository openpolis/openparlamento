<?php use_helper('Date', 'I18N') ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2><?php echo $ramo=='camera' ? 'On. ' : 'Sen. ' ?><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
			
	  <div class="W100_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'interventi', 
	                                     'parlamentare_id' => $parlamentare->getId())); ?>
	                                     	
   		<p class="tools-container"><a class="ico-help" href="#">cosa sono</a></p>
   		<div style="display: none;" class="help-box float-container">
   			<div class="inner float-container">

   				<a class="ico-close" href="#">chiudi</a><h5>cosa sono ?</h5>
   				<p>In questa pagina trovi la lista degli interventi del parlamentare in aula e in commissione</p>
   			</div>
   		</div>
   		
   		<?php include_partial('interventiFilter',
                            array('ddls_collegati' => $ddls_collegati,
                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                                                        
                                  'selected_ddls_collegati' => array_key_exists('ddls_collegati', $filters)?$filters['ddls_collegati']:0)) ?>
 
 
   		<?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults(),'route' => '@parlamentare_interventi?id='.$parlamentare->getId())); ?>


      <?php include_partial('interventiList', 
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

