<?php use_helper('Date', 'sfSimpleBlog') ?>

<li>
  <div class="<?php echo $class_even_odd ?>">

    <h3>
        <?php echo link_to_post($post) ?>
    </h3>
  
    <p class="meta"> 
      pubblicato il <strong><?php echo format_date($post->getPublishedAt('U')) ?></strong> 
      <?php if($tags = $post->getSfSimpleBlogTags(null, null, ESC_RAW)): ?>
        <?php echo __('in %1%', array('%1%' => get_tag_links($tags))) ?>
      <?php endif; ?>
      da<br/>
      <strong><?php echo $post->getAuthor() ?></strong>
    </p>
    <p class="box">
        <span class="arrow-up"></span>
        <?php if (sfConfig::get('app_sfSimpleBlog_use_post_extract', false)): ?>
          <?php echo $post->getExtract()?>
        <?php else: ?>
          <?php echo $post->getContent(ESC_RAW)?>
        <?php endif ?>
    </p>
  </div>
  <?php echo link_to_post($post, 
                          format_number_choice('[0]<strong>nessun</strong> commento|[1]<strong>un</strong> commento|(1,+Inf]<strong>%1%</strong> commenti', 
                          array('%1%' => $post->getNbComments()), $post->getNbComments()), '#comments') ?>
</li>
