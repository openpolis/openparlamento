<?php use_helper('deppVotingYesNo') ?>

<div id="monitor-n-vote">

  <h6>sei favorevole o contrario?</h6>

  <!-- blocco voting -->
  <?php echo depp_voting_block_no_ajax($emendamento, $sf_flash->has('depp_voting_message')?$sf_flash->get('depp_voting_message'):'') ?>
  <hr class="dotted" />
  
</div>
