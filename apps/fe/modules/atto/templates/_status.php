<?php if($status): ?>
  <li><h6>
  ultimo status: 
  <?php foreach($status as $data => $status_iter): ?>
  <em>
    <?php if($data!='' || $data!=null) : ?>
      <span class="date"><?php echo format_date($data, 'dd/MM/yyyy') ?></span>
   <?php endif; ?> 
   
        <?php $c = new Criteria() ?>
        <?php $c->add(OppIterPeer::ID, $status_iter, Criteria::EQUAL); ?>
        <?php $iter = OppIterPeer::doSelectOne($c) ?>
        <?php echo ($atto->getRamo()=='C'?'Camera':'Senato').": ".$iter->getFase() ?>   
             
    </em>
  <?php endforeach; ?>
  </h6></li>
<?php endif; ?>  