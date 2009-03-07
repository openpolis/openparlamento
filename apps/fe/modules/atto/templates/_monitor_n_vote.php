<?php use_helper('deppVotingYesNo') ?>

<p class="last-update">
  data di ultimo aggiornamento: <strong><?php echo $atto->getDataAgg('d-m-Y') ?></strong>
</p>

<div id="monitor-n-vote">

  <h6>monitoraggio di questo atto</h6>
  <!-- partial per la gestione del monitoring di questo atto -->
  <?php echo include_component('monitoring', 'manageItem', 
                               array('item' => $atto, 'item_type' => 'atto')); ?>

  <p><a href="#monitoringusersdo" class="action">questi utenti monitorano anche...</a></p>		
  <hr class="dotted" />			


  <h6>sei favorevole o contrario?</h6>
  <!-- blocco voting -->
  <?php echo depp_voting_block($atto) ?>
  <hr class="dotted" />
</div>
