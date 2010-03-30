<?php if($votazioni_count>0) : ?>
  <span style="color: #888888;"><?php foreach($votazioni as $votazione): ?>
	  <?php if($limit_count < $limit): ?> 
      (<?php echo link_to('vai alla votazione', '@votazione?id='.$votazione->getId()) ?>)
    <?php endif; ?>
  <?php endforeach ?></span>
<?php endif; ?>