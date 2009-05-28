<?php if($status): ?>
  <h5 class="subsection-spec">ultimo status:</h5>
  <?php foreach($status as $data => $status_iter): ?>
  <p class="iter-last-event indent">
    <?php if($data!='' || $data!=null) : ?>
      <span class="date"><?php echo format_date($data, 'dd/MM/yyyy') ?></span>
   <?php endif; ?> 
   
        <?php $c = new Criteria() ?>
        <?php $c->add(OppIterPeer::ID, $status_iter, Criteria::EQUAL); ?>
        <?php $iter = OppIterPeer::doSelectOne($c) ?>
        <?php echo ($atto->getRamo()=='C'?'Camera':'Senato').": ".$iter->getFase() ?>   
             
    </p>
  <?php endforeach; ?>
<?php endif; ?>  