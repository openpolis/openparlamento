<?php echo use_helper('PagerNavigation', 'DeppNews'); ?>
<?php setlocale(LC_TIME,"it_IT") ?>

<div class="more-results float-container">	
<ul>
  <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
     <li class="news-day float-container">
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
          
      <ul class="news-list">
      <?php foreach ($news as $n): ?>
        <li><?php echo news_text($n,$context) ?></li>
      <?php endforeach ?>
      </ul>
    </li>
  <?php endforeach; ?>
</ul>
</div>
