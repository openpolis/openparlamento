<?php if (!isset($error)): ?>
{ "n_comments": <?php echo $n_comments ?>,
  "comments": [
    <?php foreach ($comments as $i => $comment): ?>
{"s": <?php echo $comment->getSelection() ?>, 
 "c": {"author": "<?php echo $comment->getAuthorName() ?>", 
       "title": "<?php echo $comment->getTitle() ?>", 
       "body": "<?php echo $comment->getBody() ?>", 
       "date": "<?php echo $comment->getCreatedAt() ?>", 
       "textlength": <?php echo strlen($comment->getBody()) ?>
      }
}
    <?php if ($i < $n_comments-1): ?>,<?php endif ?>
    <?php endforeach ?>
    ]  
}
<?php else: ?>
  {"err": <?php echo $error ?>}
<?php endif; ?>
