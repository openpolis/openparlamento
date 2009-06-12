<?php use_helper('Date', 'sfSimpleBlog') ?>

<li>
  <div class="odd">
  <p style="font-size:16px; font-weight: bolder;"><?php echo link_to_post($post) ?></p>
 <p class="box">
 <span class="arrow-up"></span>
    <?php if (sfConfig::get('app_sfSimpleBlog_use_post_extract', false)): ?>
       <?php echo $post->getExtract()?>
    <?php else: ?>
       <?php echo $post->getContent(ESC_RAW)?>
    <?php endif ?>
 </p>   
</div>
</li> 