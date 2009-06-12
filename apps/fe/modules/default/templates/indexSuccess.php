<?php echo use_helper('DeppNews', 'Date'); ?>

<div id="content" class="float-container">
   
<div id="teasers">

<div class="teaser-box W33_100 float-right">
<h6>Dov'&egrave l'on. Rossi?</h6>
preview del <?php echo link_to('grafico delle distanze','/grafico_distanze') ?> 
</div>	
	
      <div id="introOP-box" class="teaser-box W66_100 float-left">
	<div id="introOP"> 
	 <h4>
	 Ogni giorno in parlamento si propongono, discutono e votano<br />
	 <em>leggi</em> che <em>cambiano</em> la <strong>TUA vita</strong>. 
	 </h4>			
	 <h3>
         <strong>Intervieni</strong>, <strong>organizzati</strong> e<br />
	 <strong>monitora</strong>. Ti riguarda, <strong>ci riguarda</strong>. 
	 </h3>
	</div>
      </div>
      <div class="clear-both"></div>
     </div>

<script type="text/javascript">
function embedIntro() {
var flashvars = {};
var params = {};
params.play = "true";
params.scale = "noscale";
params.wmode = "gpu";
params.devicefont = "true";
var attributes = {};
swfobject.embedSWF("/swf/intro-openparlamento.swf", "introOP", "643", "225", "9.0.0", "/swf/expressInstall.swf", flashvars, params, attributes);
};

jQuery(document).ready(function(){ embedIntro(); });

</script>
     
     <div id="main">
       
       <div class="W45_100 float-right">

        <!-- Box rotazione parlamentari -->    
        <?php echo include_component('default','classifiche', array('ramo'=>'0', 'classifica'=>'0','limit'=>'3')); ?>

        <div class="clear-both"></div>

        <!-- Box news dal parlamento -->
        <div class="section-box">
          <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '@feed', array('class' => 'section-box-rss')) ?>
      		<h3>ultime dal parlamento</h3>
    		</div>
        <?php include_partial('news/newslisthome',array('pager' => $pager,'context' => 1)); ?>
		  
	      <div class="clear-both"></div>
	   
	      <!-- Box attivita' utenti -->
        <div class="section-box">   
		      <h3 class="section-box-no-rss">ultime dalla comunit&agrave;</h3>
		      <ul>
    		  <?php foreach ($latest_activities as $activity): ?>
    		    <?php $news_text = community_news_text($activity); ?>
    		    <?php if ($news_text != ''): ?>
    		      <li class="float-container">
    			      <div class="date"> <?php echo $activity->getCreatedAt("d/m/Y H:i"); ?></div>							
    			      <?php echo $news_text ?>
    			    </li>         
            <?php endif ?>
          <?php endforeach; ?>
		      </ul>
    		  <div class="section-box-scroller tools-container has-next">
  		       <?php echo link_to('<strong>vedi le ultime 100 attivit&agrave;</strong>','@news_comunita',array('class' => 'see-all')) ?>
    		  </div> 
	        <div class="clear-both"></div>
	      </div>
	     </div>     
          
           <!-- in evidenza dal blog -->
          <div class="W52_100 float-left">
          <?php if (count($post_pager)>0) : ?>
          <div class="section-box"  style="padding-bottom:20px;">
             <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '/sfSimpleBlog/postsFeed/format/rss', array('class' => 'section-box-rss')) ?>
             <h3>in evidenza dal blog</h3>
             
		<ul id="blog-posts-full">
		<?php foreach($post_pager->getResults() as $post): ?> 
		     <?php include_partial('post',array('post' => $post)); ?>
		<?php endforeach; ?>
		</ul>
		<p align=right><strong><?php echo link_to('vai al blog di openparlamento','/blog') ?></strong></p>
	      	
	   <?php endif; ?>   
	  </div>
	  
	   <!-- box in evidenza dal parlamento -->
	  <?php if (count($lanci)>0) : ?>
          <div class="section-box">
	      
			<h3 class="section-box-no-rss">atti in evidenza</h3>				
				<ul id="law-n-acts-proposals">
				 <?php foreach ($lanci as $lancio) : ?>  
				     <?php include_partial('lanci',array('lancio' => $lancio)); ?> 
				  <?php endforeach; ?>	
					
				</ul>
			</div>	
			<?php endif; ?>	
	</div>
	  
      </div>
</div>      	  
