    <li id="act_<?php echo $act->getPrimaryKey()?>">

      <!-- blocco bookmarking positivo -->
      <?php if (!$act_has_been_negatively_bookmarked): ?>
        <span class="positive_bookmarking">
          <?php if (!$act_has_been_positively_bookmarked): ?>
            <?php echo link_to('Aggiungi ai preferiti', 
                               'deppBookmarking/positiveBookmark?item_model=OppAtto&item_pk='.$act_id) ?>          
          <?php else: ?>
            <?php echo link_to('Rimuovi dai preferiti', 
                               'deppBookmarking/positiveUnbookmark?item_model=OppAtto&item_pk='.$act_id) ?>          
          <?php endif; ?>
        </span>        
      <?php else: ?>
        <span class="positive_bookmarking">-</span>        
      <?php endif; ?>

      <!-- link alla pagina dell'atto -->
      (<?php echo link_to($act->getRamo().'.'.$act->getNumfase(), 
                          'atto/ddlIndex?id=' . $act->getId(),
                          array('title' => 'vai alla pagina')) ?>)


      <!-- per atti monitorati indirettamente, link ai tag associati e monitorati -->
      <?php if (!$user_is_monitoring_act): ?>
        <?php foreach ($act->getIndirectlyMonitoringTags($user->getPrimaryKey()) as $tag): ?>
          <span class="tag"><?php echo link_to(strtolower($tag->getTripleValue()), 'monitoring/acts?filter_tag_id=' . $tag->getPrimaryKey()) ?></span>
        <?php endforeach; ?>          
      <?php endif; ?>

      <!-- titolo cliccabile, con drop-down associato (nello script js) -->
      <span class="title" title="click per vedere le notizie"><?php echo $act->getTitolo() ?></span>
      
      <!--  ultimo iter con data -->
      <?php if (!is_null($act->getStatoCod())): ?>
        <span class="iter"> -
          <?php echo $act->getStatoFase() ?>
          - <?php echo $act->getStatoLastDate() ?>
        </span>  
      <?php endif ?>

      <!-- rimozione dal monitoraggio -->
      <?php if ($user_is_monitoring_act): ?>
         <span>
           <?php 
              echo link_to('Smetti di monitorare', 
                           'monitoring/removeItemFromMyMonitoredItems?item_model=OppAtto&item_pk='.$act->getPrimaryKey()) ?>
        </span>
      <?php else: ?>

        <!-- blocco bookmarking negativo -->
        <?php if (!$act_has_been_positively_bookmarked): ?>
          <span class="negative_bookmarking">
            <?php if (!$act_has_been_negatively_bookmarked): ?>
              <?php echo link_to('Smetti di monitorare', 
                                 'deppBookmarking/negativeBookmark?item_model=OppAtto&item_pk=' . $act_id) ?>          
            <?php else: ?>
              <?php echo link_to('Ri-aggiungi ai monitorati', 
                                 'deppBookmarking/negativeUnbookmark?item_model=OppAtto&item_pk=' . $act_id) ?>          
            <?php endif; ?>
          </span>
        <?php endif ?>
      <?php endif ?>

    </li>
