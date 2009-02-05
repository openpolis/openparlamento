<?php use_helper('Date', 'sfSimpleBlog') ?>

<div id="blog-posts-full">
  <h3><?php echo $post->getTitle() ?></h3>
  <p class="meta"> 
    pubblicato il <strong><?php echo format_date($post->getPublishedAt('U')) ?></strong> 
    <?php if($tags = $post->getSfSimpleBlogTags(null, null, ESC_RAW)): ?>
      <?php echo __('in %1%', array('%1%' => get_tag_links($tags))) ?>
    <?php endif; ?>
    da<br/>
    <strong><?php echo $post->getAuthor() ?></strong>
  </p>
  <a href="#comments"><?php echo format_number_choice('[0]no comments|[1]one comment|(1,+Inf]%1% comments', array('%1%' => count($post->getComments())), count($post->getComments())) ?></a>
  <hr/>
</div>
<div id="blog-post-content">

  <?php if (sfConfig::get('app_sfSimpleBlog_use_post_extract', false)): ?>
    <?php echo $post->getExtract()?>
    <br /><br />
    <?php echo $post->getContent(ESC_RAW)?>
  <?php else: ?>
    <?php echo $post->getContent(ESC_RAW)?>
  <?php endif ?>
</div>
  
