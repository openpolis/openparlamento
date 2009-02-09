<?php use_helper('Javascript') ?>

<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Argomento: <?php echo $argomento->getTripleValue() ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
		<div class="W25_100 float-right">
			<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>

			<div id="monitor-n-vote">
      	<h6>monitora questo argomento</h6>

        <!-- partial per la gestione del monitoring di questo politico -->
        <?php echo include_component('monitoring', 'manageItem', 
                                     array('item' => $argomento, 'item_type' => 'argomento')); ?>

  		</div>
    </div>
			
	  <div class="W73_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'aggiornamenti', 
	                                     'triple_value' => $triple_value)); ?>
	                                     	
  		<p class="tools-container"><a class="ico-help" href="#">eventuale testo micro-help</a></p>
  		<div style="display: none;" class="help-box float-container">
  			<div class="inner float-container">
	
  				<a class="ico-close" href="#">chiudi</a><h5>eventuale testo micro-help ?</h5>
  				<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  			</div>
  		</div>

      <?php echo include_component('argomento','quantodiscusso', array('tag' => $argomento)); ?>

      <?php echo include_component('argomento','sioccupanodi', array('tag' => $argomento)); ?>

      <?php echo include_component('argomento','argomenticorrelati', array('tag' => $argomento)); ?>
      
      <div class="clear-both"/></div>

      <h5 class="grey-888">ci sono <big><?php echo $pager->getNbResults() ?></big> notizie:</h5>
      <div class="more-results float-container">			
        <?php include_partial('newsFilter',
                              array('selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>
        <?php include_partial('news/newslist', array('pager' => $pager, 'triple_value' => $triple_value)); ?>
      </div>
	  </div>


    <div class="clear-both"/>			
    </div>
		
  </div>
</div>

<?php slot('argomento_breadcrumbs') ?>
  <?php echo link_to("Home", "@homepage") ?> /
  <?php echo link_to('Argomenti', '@argomenti') ?> /
  <?php echo $argomento->getTripleValue() ?>
<?php end_slot() ?>
