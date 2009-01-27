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

 <?php if($atto->getTipoAttoId() == '1'): ?>
<table border=1>
<tr>
<?php if ($rappresentazioni_pred=='') : ?>
  <th bgcolor="#00FF00"><?php echo ($atto->getRamo()=='C' ? 'Camera':'Senato'). " - ".format_date($atto->getDataPres(), 'dd/MM/yyyy') ?> Presentato</th>
  <?php if(count($rappresentazioni_this)!=0) : ?>
    <th>
      <?php foreach($rappresentazioni_this as $rappresentazione_this): ?>
        <?php $tempo= ($rappresentazione_this[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_this[1], 'dd/MM/yyyy').' '.$rappresentazione_this[2] ?>
      <?php endforeach; ?>
      <?php if(substr_count($tempo,'approvato')>0) : ?>
        <th bgcolor="#00FF00">
      <?php else : ?>
        <th bgcolor="#FF0000">
      <?php endif; ?>   
      <?php echo $tempo ?>       
    </th>
    <?php if(count($rappresentazioni_succ)==0) : ?>
      <th><i><?php echo 'Da Approvare'.($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
        <?php if($lettura_parlamentare_successiva): ?>
          <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
        <?php endif; ?>
      </i></th>
      <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
    <?php endif; ?>   
  <?php endif; ?>   
  <?php if(count($rappresentazioni_this)==0) : ?>
    <th><i><?php echo 'Da Approvare'.($atto->getRamo()=='C' ? ' alla Camera':' al Senato') ?>
      <?php if($lettura_parlamentare_successiva): ?>
        <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
    </i></th> 
    <th><i><?php echo 'Da Approvare'.($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?></i></th>
    <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
  <?php endif; ?>     
<?php endif ?>
	
<?php if ($rappresentazioni_pred!=='') : ?>
  <th bgcolor="#00FF00">
    <?php echo link_to($rappresentazioni_pred[0][3].'.'.$rappresentazioni_pred[0][4],'atto/index?id='.$rappresentazioni_pred[0][5]) ?>
    <br />
    <?php echo ($rappresentazioni_pred[0][3]=='C' ? 'Camera':'Senato'). " - ".format_date($rappresentazioni_pred[0][6], 'dd/MM/yyyy') ?> Presentato
    </th>
  <?php foreach($rappresentazioni_pred as $rappresentazione_pred): ?>
      <?php $tempo= ($rappresentazione_pred[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_pred[1], 'dd/MM/yyyy').' '.$rappresentazione_pred[2] ?>
      <?php $chiuso_pred=$rappresentazione_pred[2] ?>
     <?php if(substr_count($tempo,'approvato')>0) : ?>
          <th bgcolor="#00FF00">
       <?php else : ?>
          <th bgcolor="#FF0000">
       <?php endif; ?>   
       <?php echo link_to($rappresentazione_pred[3].'.'.$rappresentazione_pred[4],'atto/index?id='.$rappresentazione_pred[5]) ?>
       <br />
        <?php echo $tempo ?>       
    </th>
   <?php endforeach; ?>  
  <?php if(count($rappresentazioni_this)!=0) : ?>
    
      <?php foreach($rappresentazioni_this as $rappresentazione_this): ?>
         <?php $tempo=($rappresentazione_this[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_this[1], 'dd/MM/yyyy').' '.$rappresentazione_this[2] ?>
         <?php $chiuso_this=$rappresentazione_this[2] ?>
       <?php if(substr_count($tempo,'approvato')>0) : ?>
          <th bgcolor="#00FF00">
       <?php else : ?>
          <th bgcolor="#FF0000">
       <?php endif; ?>   
       <br />
        <?php echo $tempo ?>       
    </th>
       <?php endforeach; ?> 
    
     <?php if (($chiuso_this=='approvato con modificazioni') && ($rappresentazioni_succ=='')) : ?>
         <th><i><?php echo 'Nuova Approvazione'.($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
       <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
         </i></th>
         <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
     <?php endif ?>           
  <?php endif ?>
  <?php if(count($rappresentazioni_this)==0) : ?> 
     <th><i><?php echo 'Approvazione'.($atto->getRamo()=='C' ? ' alla Camera':' al Senato') ?>
      <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
     </i></th>
     <?php if ($chiuso_pred=='conclusione anomala per stralcio') : ?>
     <th><i>
     <?php echo 'Approvazione'.($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
     </i></th>
     <?php endif ?>  
       
     <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
  <?php endif ?>      
<?php endif ?>

<?php if ($rappresentazioni_succ!=='') : ?>
  <?php foreach($rappresentazioni_succ as $rappresentazione_succ): ?>
    
      <?php $tempo= ($rappresentazione_succ[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_succ[1], 'dd/MM/yyyy').' ' .$rappresentazione_succ[2] ?>
        <?php if(substr_count($tempo,'approvato')>0) : ?>
          <th bgcolor="#00FF00">
       <?php else : ?>
          <th bgcolor="#FF0000">
       <?php endif; ?>   
        <?php echo link_to($rappresentazione_succ[3].'.'.$rappresentazione_succ[4],'atto/index?id='.$rappresentazione_succ[5]) ?>
        <br />
        <?php echo $tempo ?>       
    </th>
   <?php endforeach; ?>  
<?php endif ?>
</tr>
</table>

<?php endif; ?>   