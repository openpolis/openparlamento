<?php use_helper('Date') ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2>On.<?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
		<div class="W25_100 float-right">
			<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>
      <?php echo include_partial('monitor', array()); ?>
		</div>
			
	  <div class="W73_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'interventi', 
	                                     'parlamentare_id' => $parlamentare->getId())); ?>
	                                     	
   		<p class="tools-container"><a class="ico-help" href="#">eventuale testo micro-help</a></p>
   		<div style="display: none;" class="help-box float-container">
   			<div class="inner float-container">

   				<a class="ico-close" href="#">chiudi</a><h5>eventuale testo micro-help ?</h5>
   				<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
   			</div>
   		</div>


	  </div>


    <div class="clear-both"/>			
    </div>
		
  </div>
</div>
