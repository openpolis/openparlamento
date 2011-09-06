<ul id="blog-posts-full">
  <?php foreach($feed->getItems() as $post): ?>
  <li>
    <?php include_partial('post',array('post' => $post)); ?>
  </li>
  <?php endforeach; ?>
</ul>
