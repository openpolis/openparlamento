<?php use_helper('Date') ?>
<div class="comment">
  <div class="author">
  <?php echo __('Posted by %1% on %2%', array(
    '%1%' => $comment->getAuthorUrl() ? link_to($comment->getAuthorName(), $comment->getAuthorUrl()) : $comment->getAuthorName(), 
    '%2%' => format_date($comment->getCreatedAt('U')))
  ) ?>
  </div>

  <div class="body">
  <?php echo $comment->getContent() ?>
  </div>
</div>
