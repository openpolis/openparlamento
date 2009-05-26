<?php use_helper('deppVotingYesNo', 'deppLaunching') ?>

<p class="last-update">
  data di ultimo aggiornamento: <strong><?php echo $atto->getDataAgg('d-m-Y') ?></strong>
</p>

<div id="monitor-n-vote">

  <h6>monitoraggio di questo atto</h6>
  <!-- component per la gestione del monitoring di questo atto -->
  <?php echo include_component('monitoring', 'manageItem', 
                               array('item' => $atto, 'item_type' => 'atto')); ?>
  <hr class="dotted" />			

  <h6>sei favorevole o contrario?</h6>

  <!-- blocco voting -->
  <?php echo depp_voting_block_no_ajax($atto, $sf_flash->has('depp_voting_message')?$sf_flash->get('depp_voting_message'):'') ?>
  <hr class="dotted" />
  
   <!-- blocco lanci home x admin -->
  <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('administrator')): ?>
    <h6>lanci in home page</h6>
    <?php echo include_partial('deppLaunching/launcher', array('object' => $atto, 'namespace' => 'home')); ?>    
    <hr class="dotted" />
  <?php endif ?>
</div>
