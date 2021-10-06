<?php echo use_helper('DeppNews', 'Date'); ?>


<div class="row">
	
	<div class="sevencol">
           

	    <!-- in evidenza dal blog -->
             <?php /*
	     <div class="section-box"  style="padding-bottom:20px;">
	       <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS', 'width' => '32', 'height' => '13')), 'https://www.openpolis.it/dove/parlamento/feed/', array('class' => 'section-box-rss')) ?>
	       <h3>ultime sul parlamento da openpolis.it</h3>
	       <?php include_partial('sfSimpleBlog/inevidenza', 
	                             array('feed' => sfFeedPeer::createFromWeb('https://www.openpolis.it/dove/parlamento/feed/'),
	                                   'limit' => 20)) ?>
	 		   <p align=right><strong><a href="https://www.openpolis.it/">vai su openpolis.it</a></strong></p>
	 	  </div>

	    */?>

	    <div class="clear-both"></div>

	    <!-- Box attivita' utenti -->
		<!--
	     <div class="section-box" style="margin-top: 2em;">   
	       <h3 class="section-box-no-rss">ultime dalla comunit&agrave;</h3>
	       <?php //include_partial('news/newslistcomm', array('latest_activities' => $latest_activities)) ?>
	     </div>
		-->

		<!-- box keyvotes -->
	   	<?php include_component('votazione','keyvotes', array('limit' => '5', 'pagina' => 'homepage', 'type' => 'key')) ?>

			<div class="clear-both"></div>
       <!-- Box news dal parlamento -->
       <div class="section-box">
         <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS', 'width' => '32', 'height' => '13')), '@feed', array('class' => 'section-box-rss')) ?>
    	   <h3>ultime dal parlamento</h3>
         <?php include_partial('news/newslisthome',array('pager' => $pager,'context' => 1)); ?>
		   </div>

	     <div class="clear-both"></div>

	</div>
	<div class="fivecol last">

		<!-- box cambio gruppo -->
	       	<?php include_component('parlamentare','cambioGruppo', array('limit' => '3', 'pagina' => 'homepage', 'ramo' => '1')) ?>

	       <br/>
	       <!-- box Maggioranza sotto e salva -->
	      	<?php // include_component('votazione','widgetVotiMaggioranza', array('limit' => '2')) ?>

	       <!-- Box rotazione parlamentari -->    
		   
	        <?php //echo include_component('default','classifiche', array('ramo'=>'0', 'classifica'=>'0','limit'=>'3')); ?>
			
	       <!-- box atti in evidenza dal parlamento -->
	       <?php if (count($lanci)>0) : ?>
	         <div class="section-box" style="padding-bottom:20px;">
	     			<h3 class="section-box-no-rss">atti in evidenza</h3>
	     			<ul id="law-n-acts-proposals">				
	     			<?php include_partial('default/lanci',array('lanci' => $lanci)) ?>
	     			</ul>
	     			<p align="right"><?php echo link_to('vai a tutti gli atti in evidenza', '@attiEvidenza') ?></p>
	         </div>	
	       <?php endif; ?>
	       
	   

	       <div class="clear-both"></div>

	</div>
	
</div> 
