<?php echo use_helper('DeppNews', 'Date'); ?>

<?php if ($sf_user->isAuthenticated()): ?>
 
    <?php echo include_component('monitoring', 'userVspolitician',
                                 array('user' => $sf_user, 'num' => 1, 
                                       'ambient' => 'home', 'legislatura' => 16)); ?>			
  

  <div class="clear-both"></div>

<?php endif; ?>

<div class="row">
	
	<div class="sevencol">

	    <!-- in evidenza dal blog -->
	     <div class="section-box"  style="padding-bottom:20px;">
	       <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), 'http://feeds.feedburner.com/openpolis?format=xml', array('class' => 'section-box-rss')) ?>
	       <h3>in evidenza dal blog di openpolis</h3>
	       <?php include_partial('sfSimpleBlog/inevidenza', 
	                             array('feed' => sfFeedPeer::createFromWeb('http://blog.openpolis.it/category/openparlamento/feed/'),
	                                   'limit' => 8)) ?>
	 		   <p align=right><strong><a href="http://blog.openpolis.it/category/openparlamento">vai al blog di openpolis</strong></p>
	 	  </div>

	    <!-- box keyvotes -->
	   	<?php include_component('votazione','keyvotes', array('limit' => '5', 'pagina' => 'homepage', 'type' => 'key')) ?>

	    <div class="clear-both"></div>

	    <!-- Box attivita' utenti -->
	     <div class="section-box" style="margin-top: 2em;">   
	       <h3 class="section-box-no-rss">ultime dalla comunit&agrave;</h3>
	       <?php include_partial('news/newslistcomm', array('latest_activities' => $latest_activities)) ?>
	     </div>     


	     <div class="clear-both"></div>

	</div>
	<div class="fivecol last">

		<!-- box cambio gruppo -->
	       	<?php include_component('parlamentare','cambioGruppo', array('limit' => '5', 'pagina' => 'homepage', 'ramo' => '1')) ?>

	       <br/>
	       <!-- box Maggioranza sotto e salva -->
	      	<?php // include_component('votazione','widgetVotiMaggioranza', array('limit' => '2')) ?>

	       <!-- Box rotazione parlamentari -->    
	        <?php echo include_component('default','classifiche', array('ramo'=>'0', 'classifica'=>'0','limit'=>'3')); ?>
	       <!-- box atti in evidenza dal parlamento -->
	       <?php if (count($lanci)>0) : ?>
	         <div class="section-box" style="padding-bottom:20px;">
	     			<h3 class="section-box-no-rss">atti in evidenza</h3>
	     			<ul id="law-n-acts-proposals">				
	     			<?php include_partial('default/lanci',array('lanci' => $lanci)) ?>
	     			</ul>
	     			<p align="right"><?php echo link_to('vai a tutti i voti in evidenza', '@attiEvidenza') ?></p>
	         </div>	
	       <?php endif; ?>


	       <div class="clear-both"></div>

	       <!-- Box news dal parlamento -->
	       <div class="section-box">
	         <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '@feed', array('class' => 'section-box-rss')) ?>
	    	   <h3>ultime dal parlamento</h3>
	         <?php include_partial('news/newslisthome',array('pager' => $pager,'context' => 1)); ?>
			   </div>

			<div class="clear-both"></div>
	</div>
	
</div> 
