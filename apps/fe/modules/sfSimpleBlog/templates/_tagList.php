<?php echo image_tag('tags_argomenti.png', array('alt'=>'TAGs / ARGOMENTI')) ?>
<hr />
<ul class="blog-extra">
  <?php foreach($tags as $tag): ?>
  <li><?php echo link_to($tag[0], 'sfSimpleBlog/showByTag?tag='.$tag[0]) ?> (<?php echo $tag[1] ?>)</li>
  <?php endforeach; ?>
</ul>
