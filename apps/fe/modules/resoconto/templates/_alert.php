<?php 
  $resoconto = OppResocontoPeer::retrieveByPK($result->propel_id);
  $num_seduta = $resoconto->getNumSeduta();
?>
  nel <a href="<?php echo $resoconto->getUrl()?>">
    resoconto <?php echo $resoconto->getStenografico()?'stenografico':'sommario' ?>
  </a> 
  della seduta <?php echo ($num_seduta?' n. ' . $num_seduta:'') ?> del <?php echo $resoconto->getData('d/m/Y') ?> - <?php echo $resoconto->getNota()?>.
