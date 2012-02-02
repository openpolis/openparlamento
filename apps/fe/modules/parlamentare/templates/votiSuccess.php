<?php use_helper('Date', 'I18N') ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2><?php echo $ramo=='camera' ? 'On. ' : 'Sen. ' ?><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
</ul>

<div class="row">
	<div class="twelvecol">
		
		<?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'voti', 
	                                     'parlamentare_id' => $parlamentare->getId(),
	                                     'parlamentare_slug' => $parlamentare->getSlug())); ?>
	                                     	
   		<p class="tools-container"><a class="ico-help" href="#">cosa sono</a></p>
   		<div style="display: none;" class="help-box float-container">
   			<div class="inner float-container">

   				<a class="ico-close" href="#">chiudi</a><h5>cosa sono ?</h5>
   				<p>In questa pagina trovi tutti i voti del parlamentare relativi alle votazioni elettroniche d'aula in cui &grave; stato presente</p>
   			</div>
   		</div>
   	

      <?php include_partial('votiFilter',
                            array('active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
                                  'selected_vote_type'   => array_key_exists('vote_type', $filters)?$filters['vote_type']:0,                                
                                  'selected_vote_vote'   => array_key_exists('vote_vote', $filters)?$filters['vote_vote']:0,
                                  'selected_vote_result' => array_key_exists('vote_result', $filters)?$filters['vote_result']:0,
                                  'selected_vote_rebel'  => array_key_exists('vote_rebel', $filters)?$filters['vote_rebel']:0)) ?>

      <?php include_partial('votiSort', array('parlamentare_id' => $parlamentare->getId())) ?>

      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults(),
                                                             'route' => '@parlamentare_voti?id='.$parlamentare->getId())); ?>

      <?php include_partial('votiList', 
                            array('pager' => $pager, 
                                  'parlamentare_id' => $parlamentare->getId(), 'id_gruppo_corrente' => $id_gruppo_corrente)) ?>

		
		
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
