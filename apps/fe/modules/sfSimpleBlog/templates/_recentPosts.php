<?php use_helper('sfSimpleBlog', 'Date') ?>
<div class="section-box">
    <?php echo link_to(image_tag('ico-rss.png', array('alt'=>'Rss')) , 'sfSimpleBlog/postsFeed?format=rss',array('class'=>'section-box-rss')) ?>
    <h6>Ultimi post</h6>
    <div class="news-disegni-decreti float-container"> 
      
	<ul>
	  <?php $cnt = 0; ?>
	  <?php foreach($post_pager->getResults() as $post): ?>
	    <?php $cnt += 1; ?>
	    <li>
	    <div style="font-size:12px; padding: 0px;"><strong><?php echo link_to_post($post) ?></strong></div>
	    <div style="font-size:10px; padding: 2px;">
	       pubblicato il <?php echo format_date($post->getPublishedAt('U')) ?>&nbsp;
	       <!-- e' importante tenere tutto su una sola linea, senza spazi tra i tag -->
	       <?php echo image_tag('ico_comment_box.png', array('alt'=>'&gt;', 'align'=>'baseline')) ?>&nbsp;<?php echo format_number_choice('[0] nessun&nbsp;|[1,+Inf] %1%', array('%1%' => $post->getNbComments()), $post->getNbComments()); ?><?php echo link_to_post($post, format_number_choice('[0,1] commento|(1,+Inf]  commenti', array(), $post->getNbComments()), $postfix = '#comments'); ?>
	    </div>
	    </li>
	  <?php endforeach; ?>
	</ul>
     </div>
</div>     	
