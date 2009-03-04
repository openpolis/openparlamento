<div class="section-box">
     <a href="/" class="section-box-rss"><img alt="RSS" src="/images/ico-rss-vuoto.png"/></a> <h6>Feed</h6>
    <div class="news-disegni-decreti float-container"> 
    
	<div style="padding: 5px;">Post<?php echo image_tag('ico-rss-small.png', array('alt'=>'FEED')) ?>
	<?php echo link_to('RSS', 'sfSimpleBlog/postsFeed?format=rss') ?>&nbsp;|&nbsp;<?php echo link_to('Atom', 'sfSimpleBlog/postsFeed') ?>
	</div>
	
	<div style="padding: 5px;">Commenti<?php echo image_tag('ico-rss-small.png', array('alt'=>'FEED')) ?>
	<?php echo link_to('RSS', 'sfSimpleBlog/commentsFeed?format=rss') ?>&nbsp;|&nbsp;<?php echo link_to('Atom', 'sfSimpleBlog/commentsFeed') ?>
	</div>  
	
    </div>
</div>    