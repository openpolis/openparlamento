<?php 
  $documento = OppDocumentoPeer::retrieveByPK($result->propel_id);
  $atto = $documento->getOppAtto();
  $tipo_atto = $atto->getOppTipoAtto();
?>
 documento <a href="http://<?php echo sfConfig::get('sf_site_url') ?>/atto/documento/id/<?php echo $documento->getId()?>"/><?php echo $documento->getTitle() ?></a>, 
 in <?php echo $tipo_atto->getDescrizione() ?> <?php echo $atto->getShortTitle() ?>, 
 presentato il <?php echo $atto->getDataPres() ?>

