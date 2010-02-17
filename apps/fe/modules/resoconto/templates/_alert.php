<?php 
  $resoconto = OppResocontoPeer::retrieveByPK($result->propel_id);
  $num_seduta = $resoconto->getNumSeduta();
?>

<a href="<?php echo $resoconto->getUrl()?>">
  <?php echo highlight_keywords(
          sprintf("resoconto %s della seduta %s del %s", 
                  $resoconto->getStenografico()?'stenografico':'sommario',
                  ($num_seduta?' n. ' . $num_seduta:''),
                  $resoconto->getData('d/m/Y')), 
          $term, 
          sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>'))?>
</a>
- <?php echo $resoconto->getNota()?>.
