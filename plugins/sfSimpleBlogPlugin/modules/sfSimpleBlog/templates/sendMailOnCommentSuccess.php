<?php use_helper('Date', 'I18N') ?>

<?php echo __('A new comment has been posted on the post "%1%".', array('%1%' => $comment->getPostTitle())) ?>


<?php echo __('Author: ').$comment->getAuthorName() ?>

<?php echo __('Email: ').$comment->getAuthorEmail() ?>

<?php echo __('Website: ').$comment->getAuthorUrl() ?>

<?php echo __('Comment: ').$comment->getContent() ?>


<?php if($comment->getIsModerated()): ?>
<?php echo __('This comment was automatically moderated and is waiting for your approval.') ?>

<?php echo __('Accept this comment:') ?>
<?php else: ?>
<?php echo __('Moderate this comment:') ?>
<?php endif; ?>

<?php echo url_for('sfSimpleBlogCommentAdmin/togglePublish?from_email=1&id='.$comment->getId(), true) ?>