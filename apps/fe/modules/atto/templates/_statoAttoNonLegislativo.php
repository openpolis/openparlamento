<?php $status = $ddl->getStatus(); ?>
<?php foreach($status as $data => $status_iter): ?>
  <p class="date">
  <?php if($data): ?>
    <?php echo format_date($data, 'dd/MM/yyyy') ?></p>
  <?php endif; ?>
  <?php $c = new Criteria() ?>
  <?php $c->add(OppIterPeer::ID, $status_iter, Criteria::EQUAL); ?>
  <?php $iter = OppIterPeer::doSelectOne($c) ?>
  <p class="gold"><?php echo $iter->getFase() ?></p>
<?php endforeach; ?> 