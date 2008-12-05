<?php if (count($monitored_acts) > 0): ?>
  <h4 id="type_<?php echo $type_id;?>" class="type">Atti di tipo <?php echo $type_denominazione; ?></h4>
  <div id="type_acts_<?php echo $type_id;?>" class="acts">
    <ul>
      <?php foreach ($monitored_acts as $act): ?>
        <?php  echo include_component('monitoring', 'actLine', 
                                     array('act' => $act, 'user' => $user, 'user_id' => $user_id)); ?>
      <?php endforeach ?>
    </ul>
  </div>  
<?php endif ?>

