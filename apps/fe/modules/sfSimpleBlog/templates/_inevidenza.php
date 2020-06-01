<ul id="blog-posts-full">
<?php $cn=0; ?>
  <?php foreach(array_slice($feed->getItems(), 0, $limit) as $post): ?>
  	<?php if (!strpos($post->getLink(),"/numeri/") and $cn<3) : ?>
    <li>
    <?php $cn=$cn+1; ?>	
      <?php include_partial('post',array('post' => $post)); ?>
    </li>
<?php endif; ?>
  <?php endforeach; ?>
</ul>
