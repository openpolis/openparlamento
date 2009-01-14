<?php use_helper('DeppNews') ?>

<?php if ($n_news>0): ?>
  <div class="section-box">
    <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS')), '/', array('class' => 'section-box-rss')) ?>
    <h6>News - <?php echo $title ?></h6>
    <div class="news-disegni-decreti float-container"> 
      <ul>
        <?php foreach ($news as $news_item): ?>
          <li><?php echo news($news_item); ?></li>
        <?php endforeach ?>
      </ul>
      <a href="<?php echo $all_news_url ?>" class="see-all tools-container">vedi tutta la cronologia</a>
    </div>
  </div>  
<?php endif ?>
