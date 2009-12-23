<?php 
  $resoconto = OppResocontoPeer::retrieveByPK($result->propel_id);
  $num_seduta = $resoconto->getNumSeduta();
  //$sede = $resoconto->getOppSede();
?>
<a href="<?php echo $resoconto->getUrl() ?>" target="_blank">
  Resoconto della seduta <?php echo ($num_seduta?' n. ' . $num_seduta:'') ?> 
  del <?php echo $resoconto->getData('d/m/Y') ?> <br />  <?php echo $resoconto->getNota()?>
</a>
  
<br /></td>

<td>
  <div class="results-meter">
    <div class="results-meter-value"><?php echo $result->getScore() ?>%</div>

<div class="results-meter-scale">
  <div style="width: <?php echo $result->getScore() ?>%;" class="results-meter-bar"> </div>
</div>
</div>
</td> 
