votazione: <?php echo link_to(highlight_keywords($result->getTitolo(), $query, sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')), add_highlight_qs($result->getInternalUri(), $query)) ?>


<span style="font-size: 11px; color: gray;">(<?php echo date("d/m/Y", strtotime($result->data_pres_dt)) ?>)</span>

