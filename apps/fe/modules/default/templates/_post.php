<?php use_helper('Date', 'sfSimpleBlog') ?>

<li>
<strong><?php echo format_date($post->getPublishedAt('U')) ?></strong>   
<p style="font-size:14px; font-weight: bolder; "> <?php echo link_to_post($post) ?> </p>
<p style="padding:2px;">
<?php if (sfConfig::get('app_sfSimpleBlog_use_post_extract', false)): ?>
     <?php echo $post->getExtract()?>
<?php else: ?>
     <?php echo $post->getContent(ESC_RAW)?>
<?php endif ?>
</p>
</li>