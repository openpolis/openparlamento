ATTO::<?php echo $result->tipo_atto_s ?>::<?php echo link_to(highlight_keywords($result->titolo, $query, sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')), add_highlight_qs($result->getInternalUri(), $query)) ?> (<?php echo $result->getScore() ?>%)

<?php if ($result->hasDescrizioneWiki == 'true'): ?>
  <p style="margin-top: 5px; margin-bottom: 10px; color: #666"><?php echo highlight_result_text(OppAttoPeer::retrieveByPK($result->propel_id)->getDescrizioneWiki(), $query, sfConfig::get('app_lucene_result_size', 200), sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')) ?></p>  
<?php endif ?>
