<?php use_helper('Date', 'I18N') ?>
<?php
slot('canonical_link');
echo "\n<link rel=\"canonical\" href=\"". url_for('@parlamentare_interventi?'. $parlamentare->getUrlParams() , true) ."\" />";
end_slot();
$ramo = isset($ramo) ? $ramo : '';
?>
<div class="row" id="tabs-container">
    <ul class="float-container tools-container" id="content-tabs">
    	<li class="current"><h2><?php echo $ramo ? ($ramo=='camera' ? 'On. ' : 'Sen. ') : ''  ?><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
    </ul>
</div>

<div class="row">
	<div class="twelvecol">
		
		<?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'interventi', 
	                                     'parlamentare_id' => $parlamentare->getId(),
	                                     'parlamentare_slug' => $parlamentare->getSlug())); ?>
	                                     	
   		<p class="tools-container"><a class="ico-help" href="#">cosa sono</a></p>
   		<div style="display: none;" class="help-box float-container">
   			<div class="inner float-container">

   				<a class="ico-close" href="#">chiudi</a><h5>cosa sono ?</h5>
   				<p>In questa pagina trovi la lista degli interventi del parlamentare in aula e in commissione</p>
   			</div>
   		</div>
   		    <?php if ( $carica !== NULL ) : ?>
   		<?php include_partial('interventiFilter',
                            array('ddls_collegati' => $ddls_collegati,
                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                                                        
                                  'selected_ddls_collegati' => array_key_exists('ddls_collegati', $filters)?$filters['ddls_collegati']:0)) ?>
 
 
   		<?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults(),'route' => '@parlamentare_interventi?'.$parlamentare->getUrlParams())); ?>


      <?php include_partial('interventiList', 
                            array('pager' => $pager, 'parlamentare_id' => $parlamentare->getId(),'parlamentare_slug' => $parlamentare->getSlug())) ?>
		                <?php else : ?>
                        <br /><p>Nessun intervento disponibile per un politico che non ha mai avuto una carica di Senatore o Deputato.</p>
                        <?php endif; ?>
		
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

