<?php 
  $resoconto = OppResocontoPeer::retrieveByPK($result->propel_id);
  $num_seduta = $resoconto->getNumSeduta();
  //$sede = $resoconto->getOppSede();
?>
<a href="<?php echo $resoconto->getUrl() ?>" target="_blank">
  Resoconto della seduta <?php echo ($num_seduta?' n. ' . $num_seduta:'') ?> 
  del <?php echo $resoconto->getData('d/m/Y') ?> <br />  <?php echo $resoconto->getNota()?>
</a>

<span style="font-size: 11px; color: gray;">(<?php echo date("d/m/Y", strtotime($result->data_pres_dt)) ?>)</span>

