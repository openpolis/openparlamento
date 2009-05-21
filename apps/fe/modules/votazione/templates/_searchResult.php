votazione: <?php echo link_to(highlight_keywords($result->getTitolo(), $query, sfConfig::get('app_lucene_result_highlighter', '<strong class="highlight">%s</strong>')), add_highlight_qs($result->getInternalUri(), $query)) ?>
<br /></td>
   <td><div class="results-meter">
            <div class="results-meter-value"><?php echo $result->getScore() ?>%</div>

            <div class="results-meter-scale">
                <div style="width: <?php echo $result->getScore() ?>%;" class="results-meter-bar"> </div>
            </div>
    </div></td>  