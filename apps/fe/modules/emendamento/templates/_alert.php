<?php 
  $emendamento = OppEmendamentoPeer::retrieveByPK($result->propel_id);
  $atto = $emendamento->getAttoPortante();
  $tipo_atto = OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id);
?>
 presentato un l'emendamento <?php echo $emendamento->getTitoloCompleto() ?>,  nel <?php echo $tipo_atto->getDescrizione() ?> <?php echo $result->titolo ?>, presentato il <?php echo $atto->getDataPres() ?>
