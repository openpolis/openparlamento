<?php use_helper('Javascript') ?>

<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Argomento: <?php echo strtolower($argomento->getTripleValue()) ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
		<div class="W25_100 float-right">
			<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>

			<div id="monitor-n-vote">
      	<h6>monitora questo argomento</h6>

        <!-- partial per la gestione del monitoring di questo argomento -->
        <?php echo include_component('monitoring', 'manageItem', 
                                     array('item' => $argomento, 'item_type' => 'argomento')); ?>
                                     
                 <?php echo include_component('argomento','argomenticorrelati', array('tag' => $argomento)); ?> 
                
                 <?php echo include_component('argomento','deputatisioccupanodi', array('tag' => $argomento)); ?> 
                 
                 <?php echo include_component('argomento','senatorisioccupanodi', array('tag' => $argomento)); ?>                    

  		</div>
    </div>
			
	  <div class="W73_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'aggiornamenti', 
	                                     'triple_value' => $triple_value)); ?>
      <div class="W48_100 float-left">                                     	
       <h5 class="subsection">indice di discussione</h5>
       <p class="tools-container"><a class="ico-help" href="#">come viene calcolato</a></p>
       <div style="display: none;" class="help-box float-container">
  	  <div class="inner float-container">
	      <a class="ico-close" href="#">chiudi</a><h5>come viene calcolato ?</h5>
  	      <p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  	   </div>
  	</div>
      <?php echo include_component('argomento','quantodiscusso', array('tag' => $argomento)); ?>
      </div>
      
       <div class="W48_100 float-right">                                     	
       <h5 class="subsection">indice di presentazione?</h5>
       <p class="tools-container"><a class="ico-help" href="#">come viene calcolato</a></p>
       <div style="display: none;" class="help-box float-container">
  	  <div class="inner float-container">
	      <a class="ico-close" href="#">chiudi</a><h5>come viene calcolato ?</h5>
  	      <p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  	   </div>
  	</div>
      <?php echo include_component('argomento','quantodiscusso', array('tag' => $argomento)); ?>
      </div>
      
      <div class="clear-both"/></div>

      <h5 class="subsection-alt">ci sono <big><?php echo $pager->getNbResults() ?></big> notizie sull'argomento:</h5>
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

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('argomenti', '@argomenti') ?> /
  <?php echo strtolower($argomento->getTripleValue()) ?>
<?php end_slot() ?>
