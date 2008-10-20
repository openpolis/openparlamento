<?php use_helper('Date') ?>
<li>
  <?php echo __('sent on')?> <?php echo format_date($comment['CreatedAt']) ?> <?php echo __('from') ?>
  <?php echo $comment['AuthorWebsite'] ? link_to($comment['AuthorName'], $comment['AuthorWebsite']) : $comment['AuthorName'] ?>

  <p><span class="arrow-up"></span>
     <?php echo $comment['Text'] ?></p>
</li>