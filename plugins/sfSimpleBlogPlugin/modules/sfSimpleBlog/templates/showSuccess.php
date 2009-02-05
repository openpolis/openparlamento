<?php use_helper('I18N') ?>
<?php if(sfConfig::get('app_sfSimpleBlog_use_ajax', true)): ?>
  <?php use_javascript(sfConfig::get('sf_prototype_web_dir') . '/js/prototype.js') ?>
<?php endif; ?>
<?php $sf_context->getResponse()->setTitle(sfConfig::get('app_sfSimpleBlog_title', 'How is life on earth?').' > '.$post->getTitle()) ?>

<?php if(sfConfig::get('app_sfSimpleBlog_use_feeds', true)): ?>
  <?php slot('auto_discovery_link_tag') ?>
    <?php echo auto_discovery_link_tag('rss', sfSimpleBlogTools::generatePostUri($post, null, 'commentsForPostFeed'), array('title' => __('Comments on post "%1%" from %2%', array('%1%' => $post->getTitle(), '%2%' => sfConfig::get('app_sfSimpleBlog_title', 'How is life on earth?'))))) ?>
  <?php end_slot() ?>
<?php endif; ?>

<span class="sfSimpleBlog">

  <?php include_partial('sfSimpleBlog/post', array('post' => $post, 'in_list' => false)) ?>
  
  <div class="comments" id="comments">

    <?php if($nb_comments = count($comments)): ?>
      <h3><?php echo format_number_choice('[1]One comment so far|(1,+Inf]%1% comments so far', array('%1%' => $nb_comments), $nb_comments) ?></h3>
    <?php endif; ?>
    <div id="sfSimpleBlog_comment_list">
      <?php include_partial('sfSimpleBlog/comment_list', array('post' => $post, 'comments' => $comments)) ?>
    </div>

  </div>

</span>

<?php include_partial('sfSimpleBlog/sidebar') ?>
