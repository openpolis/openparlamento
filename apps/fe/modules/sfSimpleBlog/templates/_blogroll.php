<div class="section-box">
   <a href="/" class="section-box-rss"><img alt="RSS" src="/images/ico-rss-vuoto.png"/></a><h6>Link</h6>
    
 <div class="news-disegni-decreti float-container">
   
  <?php foreach(sfConfig::get('app_sfSimpleBlog_blogroll', array(
    array('title' => 'how is life on earth?', 'url' => 'http://www.howislifeonearth.com'),
    array('title' => 'google', 'url' => 'http://www.google.com')
  )) as $blog): ?>
  <div style="padding: 5px;"><?php echo link_to($blog['title'], $blog['url']) ?></div>
  <?php endforeach; ?>
  </div>
</div>  