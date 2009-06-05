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
        </div>                             
                                     
                 <?php echo include_component('argomento','argomenticorrelati', array('tag' => $argomento)); ?> 
                
                 <?php echo include_component('argomento','deputatisioccupanodi', array('tag' => $argomento)); ?> 
                 
                 <?php echo include_component('argomento','senatorisioccupanodi', array('tag' => $argomento)); ?>                    

  		
    </div>
			
	  <div class="W73_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'aggiornamenti', 
	                                     'triple_value' => $triple_value)); ?>
      

      
      <div class="clear-both"/></div>


			<h5 class="subsection-alt">Atti presentati sull'argomento</h5>
      <?php include_component('argomento', 'attiTaggati', 
                              array('triple_value' => $triple_value,
                                    'ramo'=> 'C')) ?>

      <h5 class="subsection-alt">ci sono <big><?php echo $pager->getNbResults() ?></big> notizie sull'argomento:</h5> 
     		
        <?php include_partial('newsFilter',
                              array('selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>
        <?php include_partial('news/newslist', array('pager' => $pager, 'triple_value' => $triple_value, 'context' => 1)); ?> 
        <div style="text-align:right;"><?php echo link_to("<strong>vedi tutta la cronologia</strong>", '@news_tag?id='.$argomento->getId()) ?></div>
      
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
