<?php if($ddl_di_conversione && $ddl->getSucc()): ?>
  <?php echo link_to($ddl_di_conversione->getRamo().'.'.$ddl_di_conversione->getNumfase(), 'atto/index?id='.$ddl_di_conversione->getId()) ?> 	   
<?php endif; ?>