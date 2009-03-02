<div class="section-box">
     <a href="/" class="section-box-rss"><img alt="RSS" src="/images/ico-rss-vuoto.png"/></a> <h6>Feed</h6>
    <div class="news-disegni-decreti float-container"> 
    
	<div style="padding: 5px;"><?php echo link_to('Post', 'sfSimpleBlog/postsFeed?format=rss') ?> 
	    <?php echo link_to(image_tag('ico-rss-small.png', array('alt'=>'FEED')) . ' Rss' , 'sfSimpleBlog/postsFeed?format=rss') ?>
	</div>
	  
	<div style="padding: 5px;">
	<?php echo link_to('Post', 'sfSimpleBlog/postsFeed') ?>
	    <?php echo link_to(image_tag('ico-rss-small.png', array('alt'=>'FEED')) . ' Atom' , 'sfSimpleBlog/postsFeed') ?>
	</div> 
	
	<div style="padding: 5px;">
	<?php echo link_to(__('Comments'), 'sfSimpleBlog/commentsFeed?format=rss') ?>
	    <?php echo link_to(image_tag('ico-rss-small.png', array('alt'=>'FEED')) . ' Rss' , 'sfSimpleBlog/commentsFeed?format=rss') ?>
	</div>
	
	<div style="padding: 5px;">
	<?php echo link_to(__('Comments'), 'sfSimpleBlog/commentsFeed') ?>
	    <?php echo link_to(image_tag('ico-rss-small.png', array('alt'=>'FEED')) . ' Atom' , 'sfSimpleBlog/commentsFeed') ?>
	</div> 
	
    </div>
</div>    