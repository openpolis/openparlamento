<?php 
  $emendamento = OppEmendamentoPeer::retrieveByPK($result->propel_id);
  $atto = $emendamento->getAttoPortante();
  $tipo_atto = $atto->getOppTipoAtto();
?>

<?php echo link_to_in_mail(
  highlight_keywords(
    sprintf("emendamento %s", $emendamento->getTitoloCompleto(), 
    $term, 
    sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')), 
    add_highlight_qs($result->getInternalUri(), $term))) ?> 
-
presentato il <?php echo $emendamento->getDataPres('d/m/Y') ?>,
relativo a <?php echo $tipo_atto->getDescrizione() ?> <?php echo $atto->getShortTitle() ?>, 
