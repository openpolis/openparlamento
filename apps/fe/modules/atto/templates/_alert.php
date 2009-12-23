<?php 
  $atto = OppAttoPeer::retrieveByPK($result->propel_id);
  $tipo_atto = OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id);
?>
 nel <?php echo $tipo_atto->getDescrizione() ?> <?php echo $result->titolo ?>, presentato il <?php echo $atto->getDataPres() ?>

