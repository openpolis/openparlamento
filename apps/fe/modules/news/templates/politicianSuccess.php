<?php use_helper('PagerNavigation', 'DeppNews') ?>
<?php setlocale(LC_TIME,"it_IT") ?>


<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <li><?php echo link_to('pagina di ' . $politician, '@parlamentare?id='.$politician_id) ?></li>
            <?php if ($sf_user->isAuthenticated()): ?>
              <li><?php echo link_to('i parlamentari monitorati', 'monitoring/politicians') ?></li>              
            <?php endif ?>
          </ul>
        </div>
      </div>      
    </div>
    
   <div class="W73_100 float-left">
    <h4 class="subsection">Tutte le notizie relative a <?php echo $politician ?><?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS')), '/', array('style' => 'vertical-align:middle; padding:5px;')) ?></h4>
   <p style="padding: 5px; font-size:14px;">Ci sono <strong><?php echo $pager->getNbResults() ?></strong> notizie. Sono visualizzate cronologicamente dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>.</p>

   <div class="more-results float-container">	
    <ul>
      <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
        <li class="news-day float-container">
          <!--<h6>-->   
          <?php if ($date_ts > 0): ?>
          <div class="news-time">
	    <strong class="day"><?php echo date("d", $date_ts); ?></strong>
            <strong class="month"><?php echo strftime("%b", $date_ts); ?></strong>
            <strong class="year"><?php echo date("Y", $date_ts); ?></strong>
          </div>
          <?php else: ?>
          <div class="news-time">
           <strong class="day">NO</strong>
            <strong class="month">data</strong>
            <strong class="year"></strong>
          </div>  
          <?php endif ?>
          <!--</h6>-->
          <ul class="news-list">
          <?php foreach ($news as $n): ?>
            <li><?php echo news_text($n,2) ?></li>
          <?php endforeach ?>
          </ul>
          
        </li>
      <?php endforeach; ?>
    </ul>
   </div> 

    <?php echo pager_navigation($pager, '@news_parlamentare?id='.$politician_id, true, 7) ?>

  </div>
 </div>
</div>