<?php echo use_helper('I18N'); ?>


<tr id="act_<?php echo $act->getPrimaryKey()?>">
	<th>
    <!-- blocco bookmarking positivo -->
    <?php if (!$act_has_been_negatively_bookmarked): ?>
        <?php if (!$act_has_been_positively_bookmarked): ?>
          <?php echo link_to('*', 
                             'deppBookmarking/positiveBookmark?item_model=OppAtto&item_pk='.$act_id,
                             array('class' => 'ico-star', 'title' => 'aggiungi ai preferiti')) ?>          
        <?php else: ?>
          <?php echo link_to('*', 
                             'deppBookmarking/positiveUnbookmark?item_model=OppAtto&item_pk='.$act_id,
                             array('class' => 'ico-star bookmark', 'title' => 'rimuovi dai preferiti')) ?>          
        <?php endif; ?>
    <?php else: ?>
      <span class="positive_bookmarking">-</span>        
    <?php endif; ?>

	</th>
	<th>
	  <!-- link alla pagina dell'atto -->
    <em><?php echo link_to(content_tag('em', $act->getRamo().'.'.$act->getNumfase()) . '&nbsp;' . $act->getTitolo(),
                           'atto/index?id=' . $act->getId(),
                           array('title' => 'vai alla pagina')) ?></em>


   
	</th>
	<td>
	  <p class="date"><?php echo $act->getStatoLastDate('d/m/Y') ?></p>
	  <p class="gold">
	    <?php if (!is_null($act->getStatoCod())): ?>
        <?php echo $act->getStatoFase() ?>
      <?php endif ?>
	  </p>
	</td>
	<td>
	  <?php if (!$user_is_monitoring_act): ?>
      <?php foreach ($act->getIndirectlyMonitoringTags($user->getPrimaryKey()) as $i => $tag): ?>
        <?php echo link_to(strtolower($tag->getTripleValue()), 
                          'monitoring/acts?filter_tag_id=' . $tag->getPrimaryKey(),
                          array('class' => 'action')) ?>
        <?php if ($i < count($act->getIndirectlyMonitoringTags($user->getPrimaryKey())) ): ?>
          <br/>
        <?php endif ?>
      <?php endforeach; ?>          
    <?php endif; ?>
    
	</td>
	<td scope="row">
	  <p class="float-right">
      <a class="action btn-open-table" href="#">
        (<?php echo format_number_choice( 
          '[0]0|[1]1 nuova|(1,+Inf]%1% nuove', 
          array('%1%' => $act->getNNewNews($sf_user->getAttribute('last_login', null, 'subscriber'))),
          $act->getNNewNews($sf_user->getAttribute('last_login', null, 'subscriber'))) 
        ?>) 
        - <span>ultima</span>: <?php echo $act->getLastNews()->getDate('d/m/Y') ?></span>
      </a>
	  </p>
	</td>
	<td><?php echo image_tag('ico-thumb-up-big.png', 
	                         array('alt' => 'favorevole', 
	                               'class' => 'ico-thumb-up-big')) ?></td>
	<td>
    <!-- rimozione dal monitoraggio -->
    <?php if ($user_is_monitoring_act): ?>
         <?php 
            echo link_to('x', 
                         'monitoring/removeItemFromMyMonitoredItems?item_model=OppAtto&item_pk='.$act->getPrimaryKey(),
                         array('class' => 'ico-stop_monitoring')) ?>
    <?php else: ?>

      <!-- blocco bookmarking negativo -->
      <?php if (!$act_has_been_positively_bookmarked): ?>
        <?php if (!$act_has_been_negatively_bookmarked): ?>
          <?php echo link_to('o', 
                             'deppBookmarking/negativeBookmark?item_model=OppAtto&item_pk=' . $act_id,
                             array('class' => 'ico-stop_monitoring', 'title' => 'smetti di monitorare')) ?>          
        <?php else: ?>
          <?php echo link_to('ri-aggiungi ai monitorati', 
                             'deppBookmarking/negativeUnbookmark?item_model=OppAtto&item_pk=' . $act_id,
                              array('class' => 'ico-start_monitoring', 'title' => 'ri-aggiungi ai monitorati')) ?>          
        <?php endif; ?>
      <?php endif ?>
    <?php endif ?>
	</td>
</tr>
<tr>
	<td colspan="5">
			<div style="display: none;" class="news-parlamentari float-container"> 
			<ul>
				<li>
					<strong>23-10-2008</strong>
					<p><a href="singolo_atto.html">C.1386-B</a> <br/>
					interventi in commissione cultura della <a href="#" class="tools-container">Camera</a></p>
				</li>
				<li>
					<strong>18-10-2008</strong>
					<p><a href="singolo_atto.html">C.1386-B</a><br/>
					aggiunto nuovo co-firmatario</p>
				</li>
				<li>
					<strong>17-10-2008</strong>
					<p><a href="singolo_atto.html">C.1386-B</a><br/>
					aggiunto nuovo co-firmatario</p>
				</li>
				<li>
					<strong>09-10-2008</strong>
					<p><a href="singolo_atto.html">C.1386-B</a><br/>
					assegnato in commissione</p>
				</li>
				<li>
					<strong>09-10-2008</strong>
					<p><a href="singolo_atto.html">C.1386-B</a><br/>
					presentato</p>
				</li>
			</ul>
			<a href="#" class="see-all tools-container">vedi tutte</a>
			</div>
	</td>
	<td/>
	<td/>
</tr>

