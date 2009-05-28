<?php use_helper('DeppNews') ?>
 
<?php if (count($news)>0): ?>
  <div class="section-box">
    <?php if (isset($rss_link)): ?>
      <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS')), $rss_link, array('class' => 'section-box-rss')) ?>      
    <?php endif ?>
    <h6>News - <?php echo $title ?></h6>
    <div class="news-disegni-decreti float-container"> 
      
        <?php foreach ($news as $news_item): ?>
          <?php echo news($news_item,$context); ?>
        <?php endforeach ?>
      <?php echo link_to("vedi tutta la cronologia", $all_news_url, array('class'=>"see-all tools-container")) ?>
    </div>
  </div>  
<?php endif ?>
