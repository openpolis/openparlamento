<?php echo use_helper('PagerNavigation', 'DeppNews'); ?>
<?php setlocale(LC_TIME,"it_IT") ?>

<table class="table-news">
  <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
     <?php $primo_item=1 ?>
      <?php echo ($primo_item==1 ? '<tr><td>&nbsp;</td></tr>' : '') ?>
      <tr>
      
      <?php if ($date_ts > 0): ?>
      <td style="width: 80px;">
          <div class="news-time">
	    <strong class="day"><?php echo date("d", $date_ts); ?></strong>
            <strong class="month"><?php echo strftime("%b", $date_ts); ?></strong>
            <strong class="year"><?php echo date("Y", $date_ts); ?></strong>
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
          
     
      <?php foreach ($news as $n): ?>
      <?php if($primo_item==0) echo "<tr><td>&nbsp;</td>" ?>
      <?php  echo news_text($n,$context) ?> 
       <?php $primo_item=0 ?>
      </tr>  
      <?php endforeach ?>
      
  <?php endforeach; ?>
</table>
  
<div class="section-box-scroller tools-container has-next">
<?php echo link_to('<strong>vedi tutta la cronologia</strong>','@news_home',array('class' => 'see-all')) ?>
  </div>