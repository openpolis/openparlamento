<?php use_helper('I18N') ?>

<ul id="blog-post-comments">
  <?php foreach($comments as $comment): ?>
    <?php include_partial('sfSimpleBlog/comment', array('comment' => $comment)) ?>
  <?php endforeach; ?>
</ul>

<?php if(!sfConfig::get('app_sfSimpleBlog_comment_enabled', true) || !$post->allowComments()): ?>
  <div class="related_details"><?php echo __('Comments are closed.') ?></div>
<?php elseif($sf_flash->get('add_comment') == 'moderated'): ?>
  <div class="comment moderated"><?php echo __('Your comment has been submitted and is awaiting moderation') ?></div>
<?php elseif($sf_flash->get('add_comment') != 'normal'): ?>
  <?php include_partial('sfSimpleBlog/add_comment', array('post' => $post, 'user'=>$user)) ?>
<?php endif; ?>