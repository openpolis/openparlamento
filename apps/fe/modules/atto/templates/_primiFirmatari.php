<b>Primi firmatari</b>

<br />
<?php 
    use_helper('Slugger');
    foreach($primi_firmatari as $id => $primo_firmatario): ?>
  <?php $info_array = explode('*', $primo_firmatario ); ?>
  <?php echo format_date($info_array[0], 'dd/MM/yyyy').' - '.link_to($info_array[1], '@parlamentare?id='.$id.'&slug='.slugify($info_array[0])) ?>
  <br />
<?php endforeach; ?>
<br /><br />