<h2><?php echo __('Feeds') ?></h2>
<ul>
<li><?php echo link_to(__('Posts (RSS)'), 'sfSimpleBlog/postsFeed?format=rss') ?></li>
<li><?php echo link_to(__('Posts (Atom)'), 'sfSimpleBlog/postsFeed') ?></li>
<li><?php echo link_to(__('Comments (RSS)'), 'sfSimpleBlog/commentsFeed?format=rss') ?></li>
<li><?php echo link_to(__('Comments (Atom)'), 'sfSimpleBlog/commentsFeed') ?></li>
</ul>