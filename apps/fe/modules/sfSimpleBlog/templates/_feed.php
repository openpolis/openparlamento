<?php echo image_tag('feeds.png', array('alt'=>'FEED')) ?>
<hr />
<ul class="blog-extra">
<li><?php echo link_to('Post', 'sfSimpleBlog/postsFeed?format=rss') ?> 
    (<?php echo link_to(image_tag('ico_feed.png', array('alt'=>'FEED')) . 'RSS' , 'sfSimpleBlog/postsFeed?format=rss') ?>)</li>
<li><?php echo link_to('Post', 'sfSimpleBlog/postsFeed') ?>
    (<?php echo link_to(image_tag('ico_feed.png', array('alt'=>'FEED')) . 'Atom' , 'sfSimpleBlog/postsFeed') ?>)</li>
<li><?php echo link_to(__('Comments'), 'sfSimpleBlog/commentsFeed?format=rss') ?>
    (<?php echo link_to(image_tag('ico_feed.png', array('alt'=>'FEED')) . 'RSS' , 'sfSimpleBlog/commentsFeed?format=rss') ?>)</li>
<li><?php echo link_to(__('Comments'), 'sfSimpleBlog/commentsFeed') ?>
    (<?php echo link_to(image_tag('ico_feed.png', array('alt'=>'FEED')) . 'Atom' , 'sfSimpleBlog/commentsFeed') ?>)</li>
</ul>