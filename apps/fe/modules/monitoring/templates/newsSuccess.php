<?php echo use_helper('Javascript', 'PagerNavigation'); ?>


<?php echo include_component('monitoring', 'submenu', array('current' => 'news')); ?>

<h2>Le tue notizie (<?php echo $pager->getNbResults() ?>)</h2>

<?php echo pager_navigation($pager, 'monitoring/news') ?>

<ul>
  <?php foreach ($pager->getResults() as $n): ?>
    <li id="news_<?php echo $n->getId()?>">
      <?php echo $n->getCreatedAt() ?> - 
      generata da <?php echo $n->getGeneratorModel() ?> (<?php echo $n->getGeneratorPrimaryKeys() ?>)
      collegata a <?php echo $n->getRelatedMonitorableModel() ?> (<?php echo $n->getRelatedMonitorableId() ?>)
      data relativa: <?php echo $n->getDate() ?>
    </li>
  <?php endforeach; ?>
</ul>

<?php echo pager_navigation($pager, 'monitoring/news') ?>
