<h5 class="subsection">lo stato di avanzamento del disegno di legge:</h5>
<p class="tools-container"><?php echo link_to("cos'&egrave; lo stato di avanzamento", '#', array( 'class'=>'ico-help')) ?></p>
<div class="help-box float-container" style="display: none;">
  <div class="inner float-container">
    <div class="go-wikipedia">
      <?php echo link_to('approfondisci su<br />'.image_tag('ico-wikipedia.png', array('alt' => 'wikipedia').'<strong>Wikipedia</strong>'), '#') ?>
    </div>
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close')) ?>
    <h5>cos'&egrave; lo stato di avanzamento ?</h5>
    <p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  </div>
</div>
<br />

<?php if ($atto->getTipoAttoId()==1) : ?>
<ul class="iter float-container">

 

<!-- CTRL SE HA PRED -->



<?php if ($rappresentazioni_pred) : ?>
   
    <?php if($rappresentazioni_pred[0][7]!='12') : ?>
       <li class="step-done"><span class="date"><?php echo format_date($rappresentazioni_pred[0][6], 'dd/MM/yyyy') ?></span><strong><?php echo link_to($rappresentazioni_pred[0][3].'.'.$rappresentazioni_pred[0][4],'atto/index?id='.$rappresentazioni_pred[0][5]) ?></strong>
       <p>presentato<?php echo ($rappresentazioni_pred[0][3]=='C' ? ' alla Camera':' al Senato') ?></p></li> 
    <?php else : ?>
        <li class="step-done"><span class="date"><?php echo format_date($rappresentazioni_pred[0][6], 'dd/MM/yyyy') ?></span><strong><?php echo link_to('DL.'.$rappresentazioni_pred[0][4],'atto/index?id='.$rappresentazioni_pred[0][5]) ?></strong>
        <p>entrata in vigore del DL</p></li> 
    <?php endif; ?>    
   <?php foreach($rappresentazioni_pred as $rappresentazione_pred): ?>
    <?php if($rappresentazione_pred[7]!=12) : ?>
     <?php $tempo= ($rappresentazione_pred[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_pred[1], 'dd/MM/yyyy').' '.$rappresentazione_pred[2] ?>
     <?php $chiuso_pred=$rappresentazione_pred[2] ?>
     <?php if(substr_count($tempo,'approvato')>0) : ?>
          <li class="step-done"><span class="date"><?php echo format_date($rappresentazione_pred[1], 'dd/MM/yyyy') ?></span><strong><?php echo link_to($rappresentazione_pred[3].'.'.$rappresentazione_pred[4],'atto/index?id='.$rappresentazione_pred[5]) ?></strong>
          <p><?php echo $rappresentazione_pred[2]. ($rappresentazione_pred[3]=='C' ? ' alla Camera':' al Senato') ?></p></li> 
     <?php else : ?>
          <li class="step-done"><span class="date"><?php echo format_date($rappresentazione_pred[1], 'dd/MM/yyyy') ?></span><strong><?php echo link_to($rappresentazione_pred[3].'.'.$rappresentazione_pred[4],'atto/index?id='.$rappresentazione_pred[5]) ?></strong>
          <p><?php echo $rappresentazione_pred[2]. ($rappresentazione_pred[3]=='C' ? ' alla Camera':' al Senato') ?></p></li> 
     <?php endif; ?>       
    <?php endif; ?> 
   <?php endforeach; ?> 
<?php else : ?> 
  
    <li class="step-done"><span class="date"><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?></span><p>presentato<?php echo ($atto->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
<?php endif; ?> 

<!-- ITER CHIUSO DELL'ATTO -->   
<?php if(count($rappresentazioni_this)) : ?> 
      <?php foreach($rappresentazioni_this as $rappresentazione_this): ?>
        <?php if(substr_count($rappresentazione_this[2],'approvato')>0 and $rappresentazione_this[2]!=='approvato definitivamente. Legge') : ?>
            <li class="step-done"><span class="date"><?php echo format_date($rappresentazione_this[1], 'dd/MM/yyyy') ?></span><p><?php echo $rappresentazione_this[2] ?> <?php echo ($rappresentazione_this[3]=='C' ? ' alla Camera':' al Senato') ?></p></li>
        <?php endif; ?> 
        <?php if(substr_count($rappresentazione_this[2],'approvato')==0)  : ?>
             <li class="step-done"><span class="date"><?php echo format_date($rappresentazione_this[1], 'dd/MM/yyyy') ?></span><p><?php echo $rappresentazione_this[2] ?> <?php echo ($rappresentazione_this[3]=='C' ? ' alla Camera':' al Senato') ?></p></li>
        <?php endif; ?>
        <?php if($rappresentazione_this[2]=='approvato definitivamente. Legge') : ?>
            <li class="step-done"><span class="date"><?php echo format_date($rappresentazione_this[1], 'dd/MM/yyyy') ?></span><p><?php echo "approvato" ?> <?php echo ($rappresentazione_this[3]=='C' ? ' alla Camera':' al Senato') ?></p></li>
        <?php endif; ?>
      <?php endforeach; ?>    
<?php else: ?> 
         <li><span class="date">&nbsp;</span><p>da approvare<?php echo ($atto->getRamo()=='S' ? ' al Senato':' alla Camera') ?></p></li>
<?php endif; ?>
   
  
<!--  CONTROLLO SE HA SUCC CHIUSI  -->
  
<?php if($rappresentazioni_succ) : ?>

      <?php foreach($rappresentazioni_succ as $rappresentazione_succ): ?>
          <?php if(substr_count($rappresentazione_succ[2],'approvato')>0 and $rappresentazione_succ[2]!=='approvato definitivamente. Legge') : ?>
              <li class="step-done"><span class="date"><?php echo format_date($rappresentazione_succ[1], 'dd/MM/yyyy') ?></span> <strong><?php echo link_to($rappresentazione_succ[3].'.'.$rappresentazione_succ[4], 'atto/index?id='.$rappresentazione_succ[5]) ?></strong>
              <p><?php echo $rappresentazione_succ[2].  ($rappresentazione_succ[3]=='S' ? ' in Senato':' alla Camera') ?></p>
          <?php endif; ?>   
          <?php if(substr_count($rappresentazione_succ[2],'approvato')==0)  : ?>
              <li><span class="date"><?php echo format_date($rappresentazione_succ[1], 'dd/MM/yyyy') ?></span> <strong><?php echo link_to($rappresentazione_succ[3].'.'.$rappresentazione_succ[4], 'atto/index?id='.$rappresentazione_succ[5]) ?></strong>
              <p><?php echo $rappresentazione_succ[2].  ($rappresentazione_succ[3]=='S' ? ' in Senato':' alla Camera') ?></p>
          <?php endif; ?>
          <?php if($rappresentazione_succ[2]=='approvato definitivamente. Legge')  : ?>
              <li class="step-done"><span class="date"><?php echo format_date($rappresentazione_succ[1], 'dd/MM/yyyy') ?></span> <strong><?php echo link_to($rappresentazione_succ[3].'.'.$rappresentazione_succ[4], 'atto/index?id='.$rappresentazione_succ[5]) ?></strong>
              <p><?php echo "approvato".  ($rappresentazione_succ[3]=='S' ? ' in Senato':' alla Camera') ?></p>
          <?php endif; ?>     
         
      <?php endforeach; ?>  
   
   
      <?php if($leggi_succ=='') : ?> 
            <li><span class="date">&nbsp;</span><p>diventa legge</p></li>
      <?php else: ?>
         <?php foreach($leggi_succ as $legge_succ): ?>
             <li class="step-done"><span class="date"><?php echo format_date($legge_succ[1], 'dd/MM/yyyy') ?></span> <strong><?php echo link_to($legge_succ[3].'.'.$legge_succ[4], 'atto/index?id='.$legge_succ[5]) ?></strong>
             <p>definitivamente legge</p>
          <?php endforeach; ?>           
      <?php endif; ?>
<?php else: ?>      

      <!--  NON HA SUCC CHIUSI. CONTROLLO SE HA SUCC ATTIVI -->
    
      <?php if($lettura_parlamentare_successiva) : ?>
         
        <li><span class="date"></span> <strong><?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?></strong>
        <p>da approvare <?php echo ($lettura_parlamentare_successiva->getRamo()=='S' ? ' al Senato':' alla Camera') ?></p>
        <li><span class="date">&nbsp;</span><p>diventa legge</p></li>
        
        
      <?php else: ?>    
       <?php if(count($leggi_this)==0 ) : ?>
        
               <li><span class="date">&nbsp;</span><p>da approvare<?php echo ($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?></p></li>
               <li><span class="date">&nbsp;</span><p>diventa legge</p></li>
    
               <li><span class="date">&nbsp;</span><p>diventa legge</p></li>
       <?php endif; ?>
               
     
        
      <?php endif; ?> 
  
   
       
<?php endif; ?> 
      
</ul>
<?php endif ?>