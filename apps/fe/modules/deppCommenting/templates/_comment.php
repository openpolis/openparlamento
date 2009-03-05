<?php use_helper('Date') ?>
<li>
<strong><?php echo $comment['AuthorWebsite'] ? link_to($comment['AuthorName'], $comment['AuthorWebsite']) : $comment['AuthorName'] ?></strong> ha inviato questo commento il <strong><?php echo format_date($comment['CreatedAt']) ?></strong>
  

  <p><span class="arrow-up"></span>
     <?php echo $comment['Text'] ?></p>
</li>