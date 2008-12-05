<ul>
  <?php foreach ($news as $n): ?>
    <li id="news_<?php echo $n->getId()?>" 
        class="<?php echo date('U', strtotime($n->getCreatedAt())) > date('U', strtotime($sf_user->getAttribute('last_login', null, 'subscriber')))?'new':''?>">
      <?php echo $n->getCreatedAt() ?> - 
      generata da <?php echo $n->getGeneratorModel() ?> 
      collegata a <?php echo $n->getRelatedMonitorableModel() ?> (<?php echo $n->getRelatedMonitorableId() ?>)
      data relativa: <?php echo $n->getDate() ?>
    </li>
  <?php endforeach ?>
  <?php if ($has_more>0): ?>
    <li><?php echo link_to("visualizza le altre $has_more notizie", '#') ?></li>
  <?php endif ?>
</ul>
