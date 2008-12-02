<?php if($ddl->getSucc()): ?>
  <?php echo link_to($ddl_di_conversione->getRamo().'.'.$ddl_di_conversione->getNumfase(), 'atto/ddlIndex?id='.$ddl_di_conversione->getId()) ?></td>  	   
<?php endif; ?>