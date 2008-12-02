<ul>
  <?php foreach ($monitored_acts as $act): ?>
    <?php echo include_component('monitoring', 'actLine', array('act' => $act, 'user' => $user)); ?>
  <?php endforeach ?>
</ul>