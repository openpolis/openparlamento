<ul id="blog-posts-full">
  <?php foreach(array_slice($feed->getItems(), 0, $limit) as $post): ?>
    <li>
      <?php include_partial('post',array('post' => $post)); ?>
    </li>
  <?php endforeach; ?>
</ul>
