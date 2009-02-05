<h2><?php echo __('Tags') ?></h2>
<ul>
  <?php foreach($tags as $tag): ?>
  <li><?php echo link_to($tag[0], 'sfSimpleBlog/showByTag?tag='.$tag[0]) ?> (<?php echo $tag[1] ?>)</li>
  <?php endforeach; ?>
</ul>