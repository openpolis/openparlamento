<?php if ($opp_documento->getData()): ?>
  <?php echo $opp_documento->getData() ?>
<?php elseif ($opp_documento->getCreatedAt()): ?>
  <?php echo $opp_documento->getCreatedAt() ?>
<?php else: ?>
  nessuna data
<?php endif ?>
