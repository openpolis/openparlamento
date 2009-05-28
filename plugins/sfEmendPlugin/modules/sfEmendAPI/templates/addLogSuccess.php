<?php if (!isset($error)): ?>
  {"status":"ok"}
<?php else: ?>
  {"err": <?php echo $error ?>}
<?php endif; ?>