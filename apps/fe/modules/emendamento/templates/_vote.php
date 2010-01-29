<?php use_helper('deppVotingYesNo') ?>

<div id="monitor-n-vote">

  <h6>sei favorevole o contrario?</h6>

  <!-- blocco voting -->
  <?php echo depp_voting_block_no_ajax($emendamento, $sf_flash->has('depp_voting_message')?$sf_flash->get('depp_voting_message'):'') ?>
  <hr class="dotted" />
  
</div>

<div class="section-box">     
  <h6>Vedi anche ...</h6>

  <ul>
    <li> <?php echo link_to('La lista degli altri emendamenti', '@emendamenti_atto?id='.$attoPortante->getId()) ?></li>
    <li><?php echo link_to('La scheda del ddl '.$attoPortante->getRamo().".".$attoPortante->getNumfase(),'/singolo_atto/'.$attoPortante->getId())?></li>
  </ul>
  
</div>

