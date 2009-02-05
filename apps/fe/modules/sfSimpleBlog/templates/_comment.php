<?php use_helper('Date') ?>
<li>
  inviato il <?php echo format_date($comment->getCreatedAt('U')) ?> da<br/>
  <?php echo $comment->getAuthorUrl() ? link_to($comment->getAuthorName(), $comment->getAuthorUrl()) : $comment->getAuthorName() ?>

  <p><span class="arrow-up"></span>
     <?php echo $comment->getContent() ?></p>
</li>
