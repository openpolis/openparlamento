<?php 
  $emendamento = OppEmendamentoPeer::retrieveByPK($result->propel_id);
  $atto = $emendamento->getAttoPortante();
  $tipo_atto = OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id);
?>
 presentato l'emendamento 
 <a href="http://<?php echo sfConfig::get('sf_site_url')?>/emendamento/<?php echo $emendamento->getId()?>">
   <?php echo $emendamento->getTitoloCompleto() ?>
 </a>,
 in <?php echo $tipo_atto->getDescrizione() ?> <?php echo $atto->getShortTitle() ?>, 
 presentato il <?php echo $atto->getDataPres() ?>
