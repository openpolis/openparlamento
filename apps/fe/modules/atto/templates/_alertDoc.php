<?php 
  $documento = OppDocumentoPeer::retrieveByPK($result->propel_id);
  $atto = $documento->getOppAtto();
  $tipo_atto = $atto->getOppTipoAtto();
?>


<?php echo link_to_in_mail(
  highlight_keywords(
    $tipo_atto->getDescrizione()=='comunicato del governo'?sprintf("Comunicato del governo %s", $atto->getTitolo()):sprintf("%s", $documento->getTitoloCompleto()), 
    $term, 
    sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')), 
    add_highlight_qs($result->getInternalUri(), $term)) ?> -
presentato il <?php echo $atto->getDataPres() ?>

