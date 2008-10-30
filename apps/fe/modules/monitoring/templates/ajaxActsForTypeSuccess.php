<ul>
  <?php foreach ($monitored_acts as $act): ?>
    <li id="act_<?php echo $act->getPrimaryKey()?>">
        <?php if ($act->isMonitoredByUser($user->getPrimaryKey()) == false): ?>
          <?php foreach ($act->getIndirectlyMonitoringTags($user->getPrimaryKey()) as $tag): ?>
            <span class="tag"><?php echo strtolower($tag->getTripleValue()) ?></span>
          <?php endforeach; ?>          
        <?php endif; ?>
        <span class="title"  title="click per vedere le notizie (TODO)"><?php echo $act->getTitolo() ?></span>
    </li>
  <?php endforeach ?>
</ul>