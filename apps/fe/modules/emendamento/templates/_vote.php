<?php use_helper('deppVotingYesNo') ?>



<div class="section-box">     
  <h6>Vedi anche ...</h6>

  <ul>
    <?php if(count($subEmendamenti)>0): ?>
      <li><b>Sub Emendamenti:</b></li>
      <?php foreach ($subEmendamenti as $subEmendamento) : ?>
        <li><?php echo link_to($subEmendamento->getNumfase(),'/emendamento/'.$subEmendamento->getId())?></li>
      <?php endforeach ?>
      <li>&nbsp;</li>
    <?php endif ?>    
    <li><?php echo link_to('La lista degli altri emendamenti', '@emendamenti_atto?id='.$attoPortante->getId()) ?></li>
    <li><?php echo link_to('La scheda del ddl '.$attoPortante->getRamo().".".$attoPortante->getNumfase(),'/singolo_atto/'.$attoPortante->getId())?></li>
  </ul>
  
</div>

