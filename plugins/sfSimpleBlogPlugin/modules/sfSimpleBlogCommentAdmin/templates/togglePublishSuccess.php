<?php use_helper('I18N') ?>
<h2><?php echo __('Comment publication status toggled') ?></h2>
<?php if($comment->getIsModerated()): ?>
<?php echo __('The following comment has been moderated:') ?>
<?php else: ?>
<?php echo __('The following comment has been published:') ?>
<?php endif; ?>
<br />
<?php include_partial('comment', array('sf_simple_blog_comment' => $comment)) ?>
