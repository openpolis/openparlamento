<?php echo use_helper('DeppNews', 'Date'); ?>

<div id="content" class="float-container">
   
  <div id="teasers">

    <div class="W33_100 float-right">
      <a href="http://indice.openpolis.it"><img src="https://s3-eu-west-1.amazonaws.com/op-images/banner-rapporto-big.png" border=0 /></a> 
    </div>	


    <?php if ($sf_user->isAuthenticated()): ?>
      <div class="W66_100 float-left">
        <?php echo include_component('monitoring', 'userVspolitician',
                                     array('user' => $sf_user, 'num' => 1, 
                                           'ambient' => 'home', 'legislatura' => 16)); ?>			
      </div>
  
      <div class="clear-both"></div>

    <?php else : ?>

      <div id="introOP-box" class="W66_100 float-left">
        <div id="introOP"> 
          <h4>
        	 Ogni giorno in parlamento si propongono, discutono e votano<br />
        	 <em>leggi</em> che <em>cambiano</em> la <strong>TUA vita</strong>. 
        	</h4>			
        	<h3>
            <strong>Informati, Monitora, Intervieni</strong><br />
        	 <strong>Ti</strong> riguarda, <strong>ci</strong> riguarda. 
        	</h3>
        </div>
      </div>

      <div class="clear-both"></div>


      <script type="text/javascript">
      function embedIntro() {
      var flashvars = {};
      var params = {};
      params.play = "true";
      params.scale = "noscale";
      params.allowScriptAccess = "always"; 
      params.wmode = "gpu";
      params.devicefont = "true";
      var attributes = {};
      swfobject.embedSWF("<?php echo sfConfig::get('sf_resources_host'); ?>/swf/intro-openparlamento-ti-ci.swf", 
                         "introOP", "643", "225", "9.0.0", 
                         "<?php echo sfConfig::get('sf_resources_host'); ?>/swf/expressInstall.swf", 
                         flashvars, params, attributes);
      };

      jQuery(document).ready(function(){ embedIntro(); });

      </script>

    <?php endif; ?>  

  </div>
     
  <div id="main">
       
     <div class="W45_100 float-right">
       
       <!-- Box rotazione parlamentari -->    
        <?php echo include_component('default','classifiche', array('ramo'=>'0', 'classifica'=>'0','limit'=>'3')); ?>
       <!-- box atti in evidenza dal parlamento -->
       <?php if (count($lanci)>0) : ?>
         <div class="section-box" style="padding-bottom:20px;">
     			<h3 class="section-box-no-rss">atti in evidenza</h3>
     			<ul id="law-n-acts-proposals">				
     			<?php include_partial('default/lanci',array('lanci' => $lanci)) ?>
     			</ul>
         </div>	
       <?php endif; ?>

         <!-- box cambio gruppo -->
        	   <?php //include_component('parlamentare','cambioGruppo', array('limit' => '5', 'pagina' => 'homepage', 'ramo' => '1')) ?>
        	   
       

       <div class="clear-both"></div>

       <!-- Box news dal parlamento -->
       <div class="section-box">
         <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '@feed', array('class' => 'section-box-rss')) ?>
    	   <h3>ultime dal parlamento</h3>
         <?php include_partial('news/newslisthome',array('pager' => $pager,'context' => 1)); ?>
		   </div>

       <div class="clear-both"></div>
	  
	     
   
     </div>          

     <div class="W52_100 float-left"> 
  
        <!-- in evidenza dal blog -->
         <div class="section-box"  style="padding-bottom:20px;">
           <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '/sfSimpleBlog/postsFeed/format/rss', array('class' => 'section-box-rss')) ?>
           <h3>in evidenza dal blog di openpolis</h3>
           <?php include_partial('sfSimpleBlog/inevidenza', 
                                 array('feed' =>
                                       sfFeedPeer::createFromWeb('http://blog.openpolis.it/category/openparlamento/feed/'))) ?>
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
  
  </div>

</div>      	  
