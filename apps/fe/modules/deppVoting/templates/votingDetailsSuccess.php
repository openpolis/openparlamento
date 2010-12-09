<?php if ($type == 'small'): ?>
  <?php include_component('deppVoting', 'votingDetailsSmall', array('object' => $object)) ?>  
<?php else: ?>
  <?php include_partial('deppVoting/votingDetails', array('object' => $object)) ?>
<?php endif ?>
