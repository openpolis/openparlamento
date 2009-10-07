<?php if (count($lanci)>0) : ?>
<h5 class="subsection-alt">Nei voti chiave:</h5>
<p class="tools-container"><a class="ico-help" href="#">cosa sono i voti chiave</a></p>
  			<div style="display: none;" class="help-box float-container">
  				<div class="inner float-container">		
  					<a class="ico-close" href="#">chiudi</a><h5>cosa sono i voti chiave ?</h5>
  					<p>Sono le votazioni pi&ugrave; importanti della legislatura sia per la rilevanza della materia trattata, sia per il valore politico del voto.</p>
  				</div>
  			</div>
  	<br />	
  	   <ul>	
	   <?php foreach ($lanci as $lancio) : ?>  
	     <?php if($limit_count < $limit): ?>    
                   <li class="float-container">
                   	
		<p>
		<?php echo link_to(($lancio[0]->getTitoloAggiuntivo()) ? $lancio[0]->getTitoloAggiuntivo() : $lancio[0]->getTitolo(), 'votazione/index?id='.$lancio[0]->getId()) ?>&nbsp;-&nbsp; 
		
		<?php $voto_class=""; ?>
		<?php if ($lancio[2]=="Favorevole") : ?>
		   <?php $voto_class="green thumb-approved"; ?>
		<?php endif; ?>
		<?php if ($lancio[2]=="Contrario") : ?>
		   <?php $voto_class="red thumb-rejected"; ?>
		<?php endif; ?>
		   
		 <strong><span class="<?php echo $voto_class ?>" style="display:inline; font-size:12px;background-position:100% 10%;line-height:24px"><?php echo $lancio[2] ?></span></strong></p>
		
		<!-- <span class="<?php echo $class ?>"><?php echo $lancio[2] ?></span> -->
		
                   </li>	 
            <?php $limit_count++; ?>
              <?php else: ?>
                 <?php break; ?> 
              <?php endif; ?>     
            <?php endforeach; ?>
          </ul>  
            <?php if(count($lanci) > $limit): ?>
              <p class="indent">guarda gli altri <strong><?php echo (count($lanci) - $limit) ?> </strong> voti chiave ...
                 [ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]<br /><br />
              </p>  
              <div class="more-results float-container" style="display: none;"> 
            <ul>
            <?php $limit_count = 0; ?> 	
	   <?php foreach ($lanci as $lancio) : ?>  
	     <?php if($limit_count >= $limit): ?>    
                   <li class="float-container">
                   	
		<p>
		<?php echo link_to(($lancio[0]->getTitoloAggiuntivo()) ? $lancio[0]->getTitoloAggiuntivo() : $lancio[0]->getTitolo(), 'votazione/index?id='.$lancio[0]->getId()) ?>&nbsp;-&nbsp; 
		
		<?php $voto_class=""; ?>
		<?php if ($lancio[2]=="Favorevole") : ?>
		   <?php $voto_class="green thumb-approved"; ?>
		<?php endif; ?>
		<?php if ($lancio[2]=="Contrario") : ?>
		   <?php $voto_class="red thumb-rejected"; ?>
		<?php endif; ?>
		   
		 <strong><span class="<?php echo $voto_class ?>" style="display:inline; font-size:12px;background-position:100% 10%;line-height:24px"><?php echo $lancio[2] ?></span></strong></p>
		
		<!-- <span class="<?php echo $class ?>"><?php echo $lancio[2] ?></span> -->
		
                   </li>	 
                 
              <?php else: ?>
                 <?php $limit_count++; ?>  
              <?php endif; ?>     
            <?php endforeach; ?>
          </ul>  
             <div class="more-results-close">[ <?php echo link_to('chiudi', '#', array('class'=>'btn-close action') ) ?> ]</div>
             <!-- <div class="float-right" style="padding-top:15px;">
  		  <?php echo link_to('guarda tutti i voti del parlamentare','/parlamentare_voti/'.$carica->getOppPolitico()->getId()) ?>
  	   </div> -->
                 
           </div>    
            <?php else: ?>  
                 <!-- <div class="float-right" style="padding-top:15px;
  		  <?php echo link_to('guarda tutti i voti del parlamentare','/parlamentare_voti/'.$carica->getOppPolitico()->getId()) ?>
  	        </div> -->
  	    <?php endif; ?>    
  	        <br />
<?php endif; ?>  	        