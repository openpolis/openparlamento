<?php use_helper('Javascript') ?>
<div class="row" id="tabs-container">
    <ul class="float-container tools-container" id="content-tabs">
      <li class="current"><h2>Argomento: <?php echo strtolower($argomento->getTripleValue()) ?></h2></li>
    </ul>
</div>

<div class="row">
	<div class="ninecol">
		
		 <?php echo include_partial('secondlevelmenu', 
		                               array('current' => 'aggiornamenti', 
		                                     'triple_value' => $triple_value)); ?>
		
		<div class="clear-both"/></div>


	      <?php if ($sf_flash->has('subscription_promotion')): ?>
	        <div class="flash-messages">
	          <?php echo $sf_flash->get('subscription_promotion') ?>
	        </div>
	      <?php endif; ?>

	      <?php include_component('argomento', 'attiTaggati', 
	                              array('triple_value' => $triple_value)) ?>

	      <h5 class="subsection-alt">ci sono <big><?php echo $pager->getNbResults() ?></big> notizie sull'argomento:</h5> 

	        <?php include_partial('newsFilter',
	                              array('selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>
	        <?php include_partial('news/newslist', array('pager' => $pager, 'triple_value' => $triple_value, 'context' => 3)); ?> 
	        <div style="text-align:right;"><?php echo link_to("<strong>vedi tutta la cronologia</strong>", '@news_tag?id='.$argomento->getId()) ?></div>

	</div>
	<div class="threecol last">
		
		
		<div id="monitor-n-vote"> 
      		<h6>monitora questo argomento</h6>
	      	<p class="tools-container"><a class="ico-help" href="#">che significa monitorare</a></p>
	  		<div style="display: none;" class="help-box float-container">
	  			<div class="inner float-container">

	  				<a class="ico-close" href="#">chiudi</a><h5>che significa monitorare ?</h5>
	  				<p>Registrandoti e entrando nel sito puoi attivare il monitoraggio per atti, parlamentari e argomenti. Da quel momento nella tua pagina personale e nella tua email riceverai tutti gli aggiornamenti riferiti agli elementi che stai monitorando.<br />
	  				</p>
	  			</div>
	  		</div>

	        <!-- partial per la gestione del monitoring di questo argomento -->
	        <?php echo include_component('monitoring', 'manageItem', 
	                                     array('item' => $argomento, 'item_type' => 'argomento')); ?>
        </div>                             
		<!--                 
		<?php //echo include_component('argomento','argomenticorrelati', array('tag' => $argomento)); ?> 
		-->

		<?php echo include_component('argomento','deputatisioccupanodi', array('tag' => $argomento)); ?> 

		<?php echo include_component('argomento','senatorisioccupanodi', array('tag' => $argomento)); ?>
		
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('argomenti', '@argomenti') ?> /
  <?php echo strtolower($argomento->getTripleValue()) ?>
<?php end_slot() ?>
