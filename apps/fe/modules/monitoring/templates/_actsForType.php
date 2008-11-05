<ul>
  <?php foreach ($monitored_acts as $act): ?>
    <li id="act_<?php echo $act->getPrimaryKey()?>">
      (<?php echo link_to($act->getRamo().'.'.$act->getNumfase(), 
                          'atto/ddlIndex?id=' . $act->getId(),
                          array('title' => 'vai alla pagina')) ?>)
      <?php if ($act->isMonitoredByUser($user->getPrimaryKey()) == false): ?>
        <?php foreach ($act->getIndirectlyMonitoringTags($user->getPrimaryKey()) as $tag): ?>
          <span class="tag"><?php echo link_to(strtolower($tag->getTripleValue()), 'monitoring/acts?filter_tag_id=' . $tag->getPrimaryKey()) ?></span>
        <?php endforeach; ?>          
      <?php endif; ?>
      <span class="title" title="click per vedere le notizie"><?php echo $act->getTitolo() ?></span>
      <?php if ($act->getLastIter() instanceof OppAttoHasIter): ?>
        <span class="iter"> -
          <?php echo $act->getLastIter()->getOppIter()->getFase() ?>
          - <?php echo $act->getLastIter()->getData() ?>
        </span>        
      <?php endif ?>
    </li>
  <?php endforeach ?>
</ul>