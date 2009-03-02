<?php use_helper('Date', 'sfSimpleBlog') ?>

<li>
  <div class="<?php echo $class_even_odd ?>">

    <h2>
        <?php echo link_to_post($post) ?>
    </h2>
  
    <p class="meta" style="padding: 8px 0px 2px 0px";> 
      <strong><?php echo $post->getAuthor() ?></strong> ha pubblicato questo post il 
      <strong><?php echo format_date($post->getPublishedAt('U')) ?></strong> 
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
  <p style="padding: 5px 0px 10px 0px";>
  <?php if($tags = $post->getSfSimpleBlogTags(null, null, ESC_RAW)): ?>
        <?php echo image_tag('bg-ico-tags.png', array('alt'=>'&gt;', 'align'=>'baseline')) ?>
        <?php echo __(' %1%', array('%1%' => get_tag_links($tags))) ?>
  <?php endif; ?>
  &nbsp;
  <?php echo image_tag('ico_comment.png', array('alt'=>'&gt;', 'align'=>'baseline')) ?>
  <?php echo link_to_post($post, 
                          format_number_choice('[0]<strong>nessun</strong> commento|[1]<strong>un</strong> commento|(1,+Inf]<strong>%1%</strong> commenti', 
                          array('%1%' => $post->getNbComments()), $post->getNbComments()), '#comments') ?>
  </p>                        
</li>
