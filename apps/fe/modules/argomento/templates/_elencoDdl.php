<?php foreach($atti as $id => $ddl): ?>
    <div><?php echo link_to($ddl, 'ddl/index?id='.$id) ?></div>
  <?php endforeach; ?>