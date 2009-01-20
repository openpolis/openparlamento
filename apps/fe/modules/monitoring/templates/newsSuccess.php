<?php echo use_helper('PagerNavigation', 'DeppNews'); ?>


<?php echo include_component('monitoring', 'submenu', array('current' => 'news')); ?>

<div id="content" class="tabbed float-container">
  <div id="main" class="monitoring">

    <?php include_partial('newsFilter',
                          array('tags' => $all_monitored_tags,
                                'types' => $all_monitored_acts_types, 
                                'selected_tag_id' => array_key_exists('tag_id', $filters)?$filters['tag_id']:'0',
                                'selected_act_type_id' => array_key_exists('act_type_id', $filters)?$filters['act_type_id']:'0',
                                'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:'0',
                                'selected_date' => array_key_exists('date', $filters)?$filters['date']:'0',
                                'selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>

    <h3>Le tue notizie (<?php echo $pager->getNbResults() ?>)</h3>

    <?php echo pager_navigation($pager, 'monitoring/news') ?>

    <ul>
      <?php foreach ($pager->getResults() as $n): ?>
        <li id="news_<?php echo $n->getId()?>"><?php echo news($n); ?></li>
      <?php endforeach; ?>
    </ul>

    <?php echo pager_navigation($pager, 'monitoring/news') ?>

  </div>
</div>