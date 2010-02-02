<?php 
  $atto = OppAttoPeer::retrieveByPK($result->propel_id);
  $tipo_atto = OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id);
?>
 in <?php echo $tipo_atto->getDescrizione() ?>
 <a href="http://<?php echo sfConfig::get('sf_site_url')?>/singolo_atto/<?php echo $atto->getId()?>">
   <?php echo $atto->getTitoloCompleto() ?>
 </a>, 
 presentato il <?php echo $atto->getDataPres() ?>

