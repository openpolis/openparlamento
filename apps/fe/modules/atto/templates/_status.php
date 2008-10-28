<b>Status</b>
<?php foreach($status as $data => $status_iter): ?>
  <?php echo format_date($data, 'dd/MM/yyyy') ?> <?php echo $status_iter ?>
  <br />
<?php endforeach; ?>
<br /><br />