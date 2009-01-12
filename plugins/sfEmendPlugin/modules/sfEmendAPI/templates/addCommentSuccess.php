<?php if (!isset($error)): ?>
  {<?php echo $comment->getSelection() ?>, 
   "c": {"author": <?php echo $comment->getAuthorName() ?>, 
         "title": <?php echo $comment->getTitle() ?>, 
         "body": <?php echo $comment->getBody() ?>, 
         "date": <?php echo $comment->getCreatedAt('Y-m-d H:i') ?>, 
         "textlength": <?php echo strlen($comment->getBody()) ?>
        }
  }
<?php else: ?>
  {"err": <?php echo $error ?>}
<?php endif; ?>