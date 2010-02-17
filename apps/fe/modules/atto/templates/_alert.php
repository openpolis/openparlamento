<?php 
  $atto = OppAttoPeer::retrieveByPK($result->propel_id);
  $tipo_atto = OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id);
?>

<?php echo $tipo_atto->getDescrizione() ?> - 
<?php echo link_to_in_mail(
  highlight_keywords($atto->getTitoloCompleto(), $term, 
                     sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')),
  add_highlight_qs($result->getInternalUri(), $term)) ?>
-
presentato il <?php echo $atto->getDataPres() ?>

