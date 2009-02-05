<?php slot('sfSimpleBlog_sidebar') ?>
  <?php foreach(sfConfig::get('app_sfSimpleBlog_sidebar', array('custom', 'recent_posts', 'tags', 'feeds', 'blogroll', 'meta')) as $widget): ?>

    <?php if($widget == 'feeds' && sfConfig::get('app_sfSimpleBlog_use_feeds', true)): ?>
      <?php include_partial('sfSimpleBlog/feed') ?>
    <?php elseif($widget == 'tags'): ?>
      <?php include_component('sfSimpleBlog', 'tagList') ?>
    <?php elseif($widget == 'recent_posts'): ?>
      <?php include_component('sfSimpleBlog', 'recentPosts') ?>
    <?php elseif($widget == 'meta'): ?>
      <?php include_partial('sfSimpleBlog/meta') ?>
    <?php elseif($widget == 'blogroll'): ?>
      <?php include_partial('sfSimpleBlog/blogroll') ?>
    <?php else: ?>
      <?php echo sfConfig::get('app_sfSimpleBlog_'.$widget) ?>
    <?php endif; ?>
    
  <?php endforeach; ?>
<?php end_slot() ?>