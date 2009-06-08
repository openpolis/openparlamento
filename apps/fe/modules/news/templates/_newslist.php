<?php echo use_helper('PagerNavigation', 'DeppNews', 'Date'); ?>
<?php setlocale(LC_TIME,"it_IT") ?>


<table class="table-news">
  <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
      <?php $primo_item=1 ?>
      <?php echo ($primo_item==1 ? '<tr class="data"><td>&nbsp;</td></tr>' : '') ?>
      <tr>
      <?php if ($date_ts > 0): ?>
             <?php $primo_item=1 ?>
           <td style="width: 80px;">
           <div class="news-time">
             <?php $df = new sfDateFormat('it_IT'); ?>
             <strong class="day"><?php echo $df->format($date_ts, 'dd'); ?></strong>
             <strong class="month"><?php echo $df->format($date_ts, 'MMM'); ?></strong>
             <strong class="year"><?php echo $df->format($date_ts, 'yyyy'); ?></strong>
          </div> 
          </td> 
          <?php else: ?>
            <?php $primo_item=1 ?>
           <td style="width: 80px;">
           <div class="news-time">
           <strong class="day">NO</strong>
           <strong class="month">data</strong>
           <strong class="year"></strong>
          </div>  
          </td> 
          <?php endif ?>
          
         
          
      
      <?php foreach ($news as $n): ?> 
      <?php if($primo_item==0) echo "<tr><td>&nbsp;</td>" ?>

     
     
        <?php echo news_text($n,$context) ?> 
        <?php $primo_item=0 ?>
      </tr>  
      <?php endforeach ?>
      
    
  <?php endforeach; ?>
</table>
