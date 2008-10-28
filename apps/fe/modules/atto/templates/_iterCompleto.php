<b>Iter completo</b>
<br />
<?php foreach($iter_completo as $iter => $data): ?>
  <?php echo format_date($data, 'dd/MM/yyyy') ?> <?php echo $iter ?>
  <br />
<?php endforeach; ?>
<br /><br />