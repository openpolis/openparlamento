<?php echo use_helper('DeppNews'); ?>
<?php setlocale(LC_TIME,"it_IT") ?>

<table class="table-news">
  <?php foreach ($grouped_news as $date_ts => $news): ?>
    <?php if (count($news)>0): ?>
      <?php $primo_item=1 ?>
      <?php echo ($primo_item==1 ? '<tr class="data"><td>&nbsp;</td></tr>' : '') ?>
      <tr>
      <?php if ($date_ts > 0): ?>
             <?php $primo_item=1 ?>
           <td style="width: 80px;">
           <div class="news-time">
	    <strong class="day" style="padding-left:0px; color:#FFFFFF;text-align:center;"><?php echo date("d", $date_ts); ?></strong>
            <strong class="month" style="padding-left:0px; color:#FFFFFF;text-align:center;"><?php echo strftime("%b", $date_ts); ?></strong>
            <strong class="year" style="padding-left:0px; color:#FFFFFF;text-align:center;"><?php echo date("Y", $date_ts); ?></strong>
          </div> 
          </td> 
          <?php else: ?>
            <?php $primo_item=1 ?>
           <td style="width: 80px;">
           <div class="news-time">
           <strong class="day" style="padding-left:0px; color:#FFFFFF;text-align:center;">NO</strong>
           <strong class="month" style="padding-left:0px; color:#FFFFFF;text-align:center;">data</strong>
          <strong class="year" style="padding-left:0px; color:#FFFFFF;text-align:center;"></strong>
          </div>  
          </td> 
          <?php endif ?>
          
       
        <?php foreach ($news as $n): ?>
          <?php if($primo_item==0) echo "<tr><td>&nbsp;</td>" ?>
         
            <?php echo news_text($n,1) ?>
          <?php $primo_item=0 ?>
         </tr>  
        <?php endforeach ?>
    <?php endif ?>
  <?php endforeach; ?>
</table>
<?php if ($has_more>0): ?>
  <?php echo link_to("visualizza tutte le $has_more notizie", $all_news_route.'?id='.$item_id, 
                     array('class' => 'see-all tools-container')) ?>
<?php endif ?>