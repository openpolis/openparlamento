<?php foreach(sfConfig::get('app_sfSimpleBlog_sidebar', array('custom', 'recent_posts', 'tags', 'feeds', 'blogroll', 'meta')) as $widget): ?>

  <?php if($widget == 'feeds' && sfConfig::get('app_sfSimpleBlog_use_feeds', true)): ?>
    <div style="padding:25px 0 0 0;">
    <?php include_partial('sfSimpleBlog/feed') ?>
    </div>
  <?php elseif($widget == 'tags'): ?>
  <div style="padding:25px 0 0 0;">
    <?php include_component('sfSimpleBlog', 'tagList') ?>
  </div>  
  <?php elseif($widget == 'recent_posts'): ?>
  <div style="padding:25px 0 0 0;">
    <?php include_component('sfSimpleBlog', 'recentPosts') ?>
  </div>  
  <?php elseif($widget == 'meta'): ?>
  <div style="padding:25px 0 0 0;">
    <?php include_partial('sfSimpleBlog/meta') ?>
  </div>  
  <?php elseif($widget == 'blogroll'): ?>
  <div style="padding:25px 0 0 0;">
    <?php include_partial('sfSimpleBlog/blogroll') ?>
  </div>
  <?php else: ?>
  <div style="padding:25px 0 0 0;">
    <?php echo sfConfig::get('app_sfSimpleBlog_'.$widget) ?>
  </div>  
  <?php endif; ?>
  
<?php endforeach; ?>