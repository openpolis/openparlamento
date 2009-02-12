DOC::<?php echo link_to(highlight_keywords($result->getInternalTitle(), $query, sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')), add_highlight_qs($result->getInternalUri(), $query)) ?> (<?php echo $result->getScore() ?>%)

<p style="margin-top: 5px; margin-bottom: 10px; color: #666"><?php echo highlight_result_text(OppDocumentoPeer::retrieveByPK($result->docid)->getTesto(), $query, sfConfig::get('app_lucene_result_size', 200), sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')) ?></p>  
