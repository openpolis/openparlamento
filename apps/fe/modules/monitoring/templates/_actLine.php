<?php echo use_helper('I18N', 'Date'); ?>


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
	<th scope="row">
          <p class="content-meta">
          
          <span class="date"><?php echo format_date($act->getDataPres(), 'dd/MM/yyyy') ?>,</span>
            <span><?php echo $act->getOppTipoAtto()->getDescrizione() ?><?php echo($act->getRamo()=='C' ? ' alla Camera' : ' al Senato') ?>
            <?php $f_signers= OppAttoPeer::doSelectPrimiFirmatari($act->getId()); ?>
            <?php if (count($f_signers)>0) : ?>
               <?php $c = new Criteria() ?>
               <?php $c->add(OppPoliticoPeer::ID, key($f_signers), Criteria::EQUAL); ?>
               <?php $f_signer = OppPoliticoPeer::doSelectOne($c) ?>
               <?php echo ' di '.$f_signer->getCognome().(count($f_signers)>1 ? ' e altri' : '') ?>
             <?php endif; ?>   
            </span> 
          </p>
	      <p>
            <?php echo link_to(Text::denominazioneAtto($act, 'list'), 'atto/index?id='.$act->getId()) ?>
          </p>
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
      <?php foreach ($act->getIndirectlyMonitoringTags($user_id) as $i => $tag): ?>
        <?php echo link_to(strtolower($tag->getTripleValue()), 
                          'monitoring/acts?filter_tag_id=' . $tag->getPrimaryKey(),
                          array('class' => 'action')) ?>
        <?php if ($i < count($act->getIndirectlyMonitoringTags($user_id)) ): ?>
          <br/>
        <?php endif ?>
      <?php endforeach; ?>          
    <?php endif; ?>
    
	</td>
	<td scope="row">
	  <p class="float-right">
	    <?php if (count($act->getLastNews()) > 0): ?>
        <a class="action btn-open-table" href="#">
          (<?php echo format_number_choice( 
            '[0]0|[1]1 nuova|(1,+Inf]%1% nuove', 
            array('%1%' => $act->getNNewNews($sf_user->getAttribute('last_login', null, 'subscriber'))),
            $act->getNNewNews($sf_user->getAttribute('last_login', null, 'subscriber'))) 
          ?>) 
          - <span>ultima</span>: <?php echo $act->getLastNews()->getDate('d/m/Y') ?>
        </a>
	    <?php endif ?>
	  </p>
	</td>
	<td>
    <!-- 
	  <?php if ($user_voting_act == ''): ?>
      <p class="grey-888 ico-no-vote-yet">non hai<br/>votato</p>
	  <?php endif ?>
	  -->
	  <?php if ($user_voting_act == 1): ?>
  	  <?php echo image_tag('ico-thumb-up-big.png', 
  	                         array('alt' => 'favorevole', 
  	                               'class' => 'ico-thumb-up-big')) ?>	   
	  <?php endif ?>
	  <?php if ($user_voting_act == -1): ?>
  	  <?php echo image_tag('ico-thumb-down-big.png', 
  	                         array('alt' => 'contrario', 
  	                               'class' => 'ico-thumb-down-big')) ?>	   
	  <?php endif ?>
	</td>
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
          <?php echo link_to(image_tag('/images/ico-monitoring.png'), 
                             'deppBookmarking/negativeUnbookmark?item_model=OppAtto&item_pk=' . $act_id,
                              array('class' => 'ico-start_monitoring', 'title' => 'aggiungi ai monitorati')) ?>          
        <?php endif; ?>
      <?php endif ?>
    <?php endif ?>
	</td>
</tr>
<tr>
	<td colspan="5">
		<div style="display: none;" class="news-parlamentari float-container"> 
		</div>
	</td>
	<td/>
	<td/>
</tr>

