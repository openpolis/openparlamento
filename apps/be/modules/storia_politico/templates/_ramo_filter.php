<?php
  $rami = array('C' => 'Camera', 
                'S' => 'Senato', 
                'G'  => 'Governo');
  $frami = isset($filters['rami']) ? $filters['rami'] : array();
  
?>
<div class="rami_filter">
<?php foreach ($rami as $key => $ramo): ?>
  <div class="rami_filter_group">
  <?php
    echo radiobutton_tag('filters[rami][]',
      $key, in_array($key, $frami));
  ?>
    <span class="rami_filter_group_label">
    <?php if ($key !== ''): ?>
      <label style="display:inline" 
             for="filters_rami_<?php echo $key?>_<?php echo $key?>"><?php echo $ramo; ?></label>
    <?php else: ?>
      <label style="display:inline" 
             for="filters_rami"><?php echo $ramo; ?></label>      
    <?php endif ?>
    </span>
  </div>
<?php endforeach ?>
</div>
