<b>Co-firmatari</b>
<br />
<?php foreach($co_firmatari as $id => $co_firmatario): ?>
  <?php $info_array = explode('*', $co_firmatario ); ?>
  <?php echo format_date($info_array[0], 'dd/MM/yyyy').' - '.link_to($info_array[1], '@parlamentare?id='.$id) ?>
  <br />
<?php endforeach; ?>