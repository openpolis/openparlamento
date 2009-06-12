<?php echo use_helper('PagerNavigation', 'DeppNews', 'Date'); ?>

<table class="table-news">
  <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
    <tr><td colspan="3">&nbsp;</td></tr>
      
    <?php foreach ($news as $i => $n): ?>
      <tr>
        <?php //if ($i==0): ?>
          <?php if ($date_ts > 0): ?>
            <td style="width: 80px;">
              <div class="news-time">    
                <?php $df = new sfDateFormat('it_IT'); ?>
                <strong class="day"><?php echo $df->format($date_ts, 'dd'); ?></strong>
                <strong class="month"><?php echo $df->format($date_ts, 'MMM'); ?></strong>
                <strong class="year"><?php echo $df->format($date_ts, 'yyyy'); ?></strong>
              </div>
            </td>    
          <?php else: ?>
            <td style="width: 80px;">
                <div class="news-time">
                 <strong class="day">NO</strong>
                  <strong class="month">data</strong>
                  <strong class="year"></strong>
                </div>
            </td>      
          <?php endif ?>
        <?php // else: ?>
          <!--<td>&nbsp;</td> -->
        <?php //endif; ?>
        <?php  echo news_text($n,$context) ?> 
      </tr>  
    <?php endforeach ?>
      
  <?php endforeach; ?>
</table>
  
<div class="section-box-scroller tools-container has-next">
<?php echo link_to('<strong>vedi tutta la cronologia</strong>','@news_home',array('class' => 'see-all')) ?>
  </div>