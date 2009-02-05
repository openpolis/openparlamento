<?php use_helper('Date', 'sfSimpleBlog') ?>
<div class="post">
  <h2>
    <?php if ($in_list): ?>
      <?php echo link_to_post($post) ?>
    <?php else: ?>
      <?php echo $post->getTitle() ?>
    <?php endif; ?>
  </h2>
  
  <div class="details">
  <?php echo __('Posted by %1% on %2%', array('%1%' => $post->getAuthor(), '%2%' => format_date($post->getPublishedAt('U')))) ?>
  <?php if($tags = $post->getSfSimpleBlogTags(null, null, ESC_RAW)): ?>
    <?php echo __('in %1%', array('%1%' => get_tag_links($tags))) ?>
  <?php endif; ?>
  <?php if ($in_list): ?>
  - <?php echo link_to_post($post, format_number_choice('[0]no comment|[1]one comment|(1,+Inf]%1% comments', array('%1%' => $post->getNbComments()), $post->getNbComments()), '#comments') ?>
  <?php endif; ?>
  </div>
  
  <div class="content">
    <?php echo $post->getContent(ESC_RAW)?>
  </div>
</div>