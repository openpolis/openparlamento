<ul id="blog-posts-full">
  <?php foreach($post_pager->getResults() as $post): ?> 
    <?php include_partial('post',array('post' => $post)); ?>
  <?php endforeach; ?>
</ul>
