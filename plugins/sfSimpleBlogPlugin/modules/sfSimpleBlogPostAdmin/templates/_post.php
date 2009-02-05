<?php $post = $sf_simple_blog_post ?>
<?php use_helper('Date') ?>
<h2 <?php if(!$post->getIsPublished()): ?> class="unpublished"<?php endif; ?>>
  <?php echo link_to($post->getTitle(), 'sfSimpleBlogPostAdmin/edit?id='.$post->getId()) ?>
  <?php if(!$post->getIsPublished()): echo __('(not published)'); endif; ?>
</h2>

<i><?php echo __('Posted by %1% on %2%, tagged %3%', array(
  '%1%' => $post->getAuthor(), 
  '%2%' => format_date($post->getCreatedAt('U')),
  '%3%' => $post->getTagsAsString(), 
  )) ?>
</i>
<div>
<?php echo $post->getExtract() ?>
</div>
(<?php echo format_number_choice('[0]no comment|[1]one comment|(1,+Inf]%1% comments', array('%1%' => $post->getNbComments()), $post->getNbComments()) ?>)
<?php if(!$post->allowComments()): ?>
(<?php echo __('Comments closed') ?>)
<?php endif; ?>