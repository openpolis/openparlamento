<ul>
  <?php foreach ($news as $n): ?>
    <li id="news_<?php echo $n->getId()?>">
      <?php echo $n->getCreatedAt() ?> - 
      generata da <?php echo $n->getGeneratorModel() ?> (<?php echo $n->getGeneratorId() ?>)
      collegata a <?php echo $n->getRelatedMonitorableModel() ?> (<?php echo $n->getRelatedMonitorableId() ?>)
      data relativa: <?php echo $n->getDate() ?>
    </li>
  <?php endforeach ?>
  <?php if ($has_more>0): ?>
    <li><?php echo link_to("visualizza le altre $has_more notizie", '#') ?></li>
  <?php endif ?>
</ul>

