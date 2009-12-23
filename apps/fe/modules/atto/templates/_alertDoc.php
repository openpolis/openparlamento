<?php 
  $documento = OppDocumentoPeer::retrieveByPK($result->propel_id);
  $atto = $documento->getOppAtto();
  $tipo_atto = $atto->getOppTipoAtto();
?>
 nel documento <?php echo $result->propel_id ?> del <?php echo $tipo_atto->getDescrizione() ?> <?php echo $atto->getId() ?>, presentato il <?php echo $atto->getDataPres() ?>

