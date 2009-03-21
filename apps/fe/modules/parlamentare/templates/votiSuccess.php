<?php use_helper('Date', 'I18N') ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2><?php echo $ramo=='camera' ? 'On. ' : 'Sen. ' ?><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
			
	  <div class="W100_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'voti', 
	                                     'parlamentare_id' => $parlamentare->getId())); ?>
	                                     	
   		<p class="tools-container"><a class="ico-help" href="#">eventuale testo micro-help</a></p>
   		<div style="display: none;" class="help-box float-container">
   			<div class="inner float-container">

   				<a class="ico-close" href="#">chiudi</a><h5>eventuale testo micro-help ?</h5>
   				<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
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
