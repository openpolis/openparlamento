<?php use_helper('Date') ?>
<li>
<strong><?php echo $comment->getAuthorUrl() ? link_to($comment->getAuthorName(), $comment->getAuthorUrl()) : $comment->getAuthorName() ?></strong>
  ha inviato questo commento il <strong><?php echo format_date($comment->getCreatedAt('U')) ?></strong>

  <p><span class="arrow-up"></span>
     <?php echo $comment->getContent() ?></p>
</li>
