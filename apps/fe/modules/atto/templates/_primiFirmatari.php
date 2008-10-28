<b>Primi firmatari</b>
<br />
<?php foreach($primi_firmatari as $id => $primo_firmatario): ?>
  <?php $info_array = explode('*', $primo_firmatario ); ?>
  <?php echo format_date($info_array[0], 'dd/MM/yyyy').' - '.link_to($info_array[1], '@parlamentare?id='.$id) ?>
  <br />
<?php endforeach; ?>
<br /><br />