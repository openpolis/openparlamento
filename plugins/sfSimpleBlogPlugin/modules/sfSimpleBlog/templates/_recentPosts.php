<?php use_helper('sfSimpleBlog') ?>
<h2><?php echo __('Latest posts') ?></h2>
<ul>
<?php foreach($post_pager->getResults() as $post): ?>
<li><?php echo link_to_post($post) ?></li>
<?php endforeach; ?>
</ul>