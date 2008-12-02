<?php if($status): ?>
  <b>Status</b>
  <?php foreach($status as $data => $status_iter): ?>
    <?php echo format_date($data, 'dd/MM/yyyy') ?>
    <?php $c = new Criteria() ?>
    <?php $c->add(OppIterPeer::ID, $status_iter, Criteria::EQUAL); ?>
    <?php $iter = OppIterPeer::doSelectOne($c) ?>
    <?php echo $iter->getFase() ?>
    <br />
  <?php endforeach; ?>
<?php endif; ?>  
<br /><br />