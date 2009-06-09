<?php echo use_helper('DeppNews'); ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2>Comunit&agrave;</h2></li>
</ul>



<div class="tabbed float-container" id="content">
 <div id="main">
 
 <div class="W73_100" style="font-size:14px;">
     
     <div class="intro-box"><p>Sono in cantiere strumenti che permetteranno agli utenti di openpolis di interagire tra di loro, formare gruppi di pressione per determinati atti, scrivere collettivamente ai politici, comunicare con utenti di altri social network e tanto altro.<br />
     Per suggerimenti commenta il post del blog con la descrizione dei lavori in corso</p></div>
     
  </div>
  <p>&nbsp;</p>

   <div class="W52_100 float-right">
   <div class="section-box">
	<h3 class="section-box-no-rss">gli atti pi&ugrave; seguiti dagli utenti</h3>
	<div id="atti_community">				
	  <?php echo include_component('community','attiutenti', array('type' => 'voti')); ?>	
	</div> 
	
      </div>	
      
       <p>&nbsp;</p>	
       
      <div class="section-box">
	<h3 class="section-box-no-rss" style="color:orange;">i parlamentari pi&ugrave; monitorati</h3> 
        <div id="monitor_community">				
	  <?php echo include_component('community','boxparlamentari', array('type' => 'deputati')); ?>	
	</div> 
       </div>  
    
    </div>
    
    <div class="W45_100 float-left">
      <div class="section-box">   
		
		<h3 class="section-box-no-rss">le ultime dalla comunit&agrave;</h3>
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
    
    
   </div>
	     
	       

 </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  comunit&agrave;
<?php end_slot() ?>
