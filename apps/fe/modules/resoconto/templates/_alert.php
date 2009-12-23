<?php 
  $resoconto = OppResocontoPeer::retrieveByPK($result->propel_id);
  $num_seduta = $resoconto->getNumSeduta();
?>
 nel resoconto della seduta <?php echo ($num_seduta?' n. ' . $num_seduta:'') ?> del <?php echo $resoconto->getData('d/m/Y') ?> - <?php echo $resoconto->getNota()?>, inserito in Opp il <?php echo $resoconto->getCreatedAt('d/m/Y') ?>.
