<?php use_helper('AttoIter'); ?>
<?php if ($atto->getTipoAttoId()==1 or $atto->getTipoAttoId()==12) : ?>
  <h6 style="color:#888888; margin-bottom: 12px;">
  <?php if ($atto->getTipoAttoId()==1): ?>
    <?php echo "iter parlamentare del disegno di legge:" ?> 
  <?php endif; ?>
  <?php if ($atto->getTipoAttoId()==12): ?>
    <?php echo "iter parlamentare di conversione del decreto legge:" ?>
  <?php endif; ?>       

  <span class="tools-container"><?php echo link_to("&nbsp;", '#', array( 'class'=>'ico-help')) ?></span>

  <div class="help-box float-container" style="display: none;">
    <div class="inner float-container">
      <div class="go-wikipedia">
      </div>
      <?php echo link_to('<span style="font-size:12px; font-weight:normal; color:black;">chiudi</span>', '#', array( 'class'=>'ico-close')) ?>
      <h5>cos'&egrave; l'iter ?</h5>
      <p style="font-size:12px; font-weight:normal; color:black;">L'Iter &egrave; l'insieme dei passi successivi (status) previsti perch&egrave; un <b>disegno di legge</b> arrivi alla sua approvazione finale o conclusione. Un disegno di legge per diventare legge deve essere approvato da entrambi i rami (Camera e Senato) del Parlamento.</p>
    </div>
  </div>
  <br />
  </h6>


	<!-- Relazioni -->
	
	<?php if ($atto->getTipoAttoId()==1) : ?>
	    <?php include_component('atto', 'relazioni', 
	                            array('atto'=>$atto)) ?>
	<?php endif; ?> 

  <ul class="iter float-container">
    
    
    
  <!-- CTRL se ha Pred -->
  <?php $dl=0 ?>
  <?php if (count($atto->getAllPred())>0): ?>
    <?php foreach ($atto->getAllPred() as $k=>$pred): ?>
      <?php if ($k==0): ?>
        <?php if ($pred->getTipoAttoId()=='12') :?>
          <li class="step-yes"><span class="date"><?php echo format_date($pred->getDataPres(), 'dd/MM/yyyy') ?></span><strong><?php echo link_to('DL.'.$pred->getNumfase(),'atto/index?id='.$pred->getId()) ?></strong>
          <p>entrata in vigore del DL</p></li>
          <?php $dl=1 ?>
        <?php else: ?>
          <li class="step-yes"><span class="date"><?php echo format_date($pred->getDataPres(), 'dd/MM/yyyy') ?></span><strong><?php echo link_to($pred->getRamo().'.'.$pred->getNumfase(),'atto/index?id='.$pred->getId()) ?></strong>
           <p>presentato<?php echo ($pred->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
        <?php endif ?>
      <?php endif ?>  

      <?php $status_value= array_values($pred->getStatus()) ?>
      <?php $status_date= array_keys($pred->getStatus()) ?>
      <?php if ($pred->getTipoAttoId()!='12') :?>
        <li class="<?php echo (OppIterPeer::retrieveByPk($status_value[0])->getColor()=='green'?'step-yes':'step-no') ?>"><span class="date"><?php echo format_date($status_date[0], 'dd/MM/yyyy') ?></span><strong><?php echo link_to($pred->getRamo().'.'.$pred->getNumfase(),'atto/index?id='.$pred->getId()) ?></strong>
        <p><?php echo OppIterPeer::retrieveByPk($status_value[0])->getShortName().($pred->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
      <?php endif ?>   
    <?php endforeach ?> 

  <?php else: ?>
    <?php if ($atto->getTipoAttoId()=='12') :?>
      <li class="step-yes"><span class="date"><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?></span><strong style="background-color: yellow; color:black;"><?php echo 'DL.'.$atto->getNumfase() ?></strong>
      <p>entrata in vigore del DL</p></li>
    <?php else: ?>
      <li class="step-yes"><span class="date"><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?></span><strong style="background-color: yellow; color:black;"><?php echo $atto->getRamo().'.'.$atto->getNumfase() ?></strong>
       <p>presentato<?php echo ($atto->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
    <?php endif ?>
  <?php endif ?> 
  
  <!-- Status attuale atto -->
  
  <?php $status_value= array_values($atto->getStatus()) ?>
  <?php $status_date= array_keys($atto->getStatus()) ?>
  <?php if (OppIterPeer::retrieveByPk($status_value[0])->getConcluso()==1 && $atto->getTipoAttoId()!=12): ?>
    <?php if (($status_value[0])==16) : ?>
      <li class="step-yes"><span class="date"><?php echo format_date($status_date[0], 'dd/MM/yyyy') ?></span><strong style="background-color: yellow; color:black;"><?php echo $atto->getRamo().'.'.$atto->getNumfase() ?></strong>
      <p><?php echo "approvato".($atto->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
      <li class="step-yes"><span class="date"><?php echo format_date($status_date[0], 'dd/MM/yyyy') ?></span><strong style="background-color: yellow; color:black;"><?php echo $atto->getRamo().'.'.$atto->getNumfase() ?></strong>
      <p><?php echo "divenuto legge" ?></p></li>
    <?php else :?>
        <li class="<?php echo (OppIterPeer::retrieveByPk($status_value[0])->getColor()=='green'?'step-yes':'step-no') ?>"><span class="date"><?php echo format_date($status_date[0], 'dd/MM/yyyy') ?></span><strong style="background-color: yellow; color:black;"><?php echo $atto->getRamo().'.'.$atto->getNumfase() ?></strong>
         <p><?php echo  OppIterPeer::retrieveByPk($status_value[0])->getShortName().($atto->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
    <?php endif ?>
  <?php else :?>
    <?php if ($atto->getTipoAttoId()!=12): ?>
      <li class="step-now"><span class="date">&nbsp;</span><strong style="background-color: yellow; color:black;"><?php echo $atto->getRamo().'.'.$atto->getNumfase() ?></strong>
      <p>da approvare<?php echo ($atto->getRamo()=='S' ? ' al Senato':' alla Camera') ?></p></li>
    <?php endif ?>  
  <?php endif ?>   

  <!-- Controllo se ha SUCC -->
  <?php if (count($atto->getAllSucc())>0): ?>
    <?php foreach ($atto->getAllSucc() as $k=>$succ): ?>
      <?php $status_value= array_values($succ->getStatus()) ?>
      <?php $status_date= array_keys($succ->getStatus()) ?>
      <?php if (OppIterPeer::retrieveByPk($status_value[0])->getConcluso()!=1) : ?>
        <li class="step-now"><span class="date">&nbsp;</span><strong><?php echo link_to($succ->getRamo().'.'.$succ->getNumfase(),'atto/index?id='.$succ->getId()) ?></strong>
        <p><?php echo "da approvare".($succ->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
        <li><span class="date">&nbsp;</span>
        <p>diventa legge</p></li>
      <?php else: ?>
        <?php if (($status_value[0])==16) : ?>
          <li class="step-yes"><span class="date"><?php echo format_date($status_date[0], 'dd/MM/yyyy') ?></span><strong><?php echo link_to($succ->getRamo().'.'.$succ->getNumfase(),'atto/index?id='.$succ->getId()) ?></strong>
          <p><?php echo "approvato".($succ->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
          <li class="step-yes"><span class="date"><?php echo format_date($status_date[0], 'dd/MM/yyyy') ?></span><strong><?php echo link_to($succ->getRamo().'.'.$succ->getNumfase(),'atto/index?id='.$succ->getId()) ?></strong>
          <p><?php echo "divenuto legge" ?></p></li>
          <?php else: ?>
            <li class="step-yes"><span class="date"><?php echo format_date($status_date[0], 'dd/MM/yyyy') ?></span><strong><?php echo link_to($succ->getRamo().'.'.$succ->getNumfase(),'atto/index?id='.$succ->getId()) ?></strong>
            <p><?php echo OppIterPeer::retrieveByPk($status_value[0])->getShortName().($succ->getRamo()=='C' ? ' alla Camera':' al Senato') ?></p></li>
        <?php endif ?>
      <?php endif ?>
    <?php endforeach ?>  
  <?php else: ?>
    <?php if (count($atto->getAllPred())>0): ?>
      <?php $status_value= array_values($atto->getStatus()) ?>
      <?php if (($status_value[0])!=16) : ?>
        <li><span class="date">&nbsp;</span>
        <p>diventa legge</p></li>
      <?php endif ?>  
    <?php endif ?>  
  <?php endif ?>     
  </ul>
<?php endif ?>
