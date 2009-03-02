<div class="section-box">
   <a href="/" class="section-box-rss"><img alt="RSS" src="/images/ico-rss-vuoto.png"/></a><h6>Tag</h6>
    
 <div class="news-disegni-decreti float-container">
   <div style="padding: 5px;">
  <?php foreach($tags as $tag): ?>
  <?php echo link_to($tag[0], 'sfSimpleBlog/showByTag?tag='.$tag[0]) ?> (<?php echo $tag[1] ?>)&nbsp;
  <?php endforeach; ?>
   </div>

</div>
</div>
