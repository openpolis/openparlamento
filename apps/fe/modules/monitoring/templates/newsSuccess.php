<?php echo use_helper('PagerNavigation'); ?>


<?php echo include_component('monitoring', 'submenu', array('current' => 'news')); ?>

<div id="content" class="tabbed float-container">
  <div id="main" class="monitoring">

    <h3>Le tue notizie (<?php echo $pager->getNbResults() ?>)</h3>

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

  </div>
</div>
