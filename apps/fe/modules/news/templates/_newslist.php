<?php echo use_helper('PagerNavigation', 'DeppNews'); ?>
<?php setlocale(LC_TIME,"it_IT") ?>

<table style="width: 100%; vertical-align: top; margin-bottom: 20px; color: #626262; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
  <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
     <tr>
      
      <?php if ($date_ts > 0): ?>
             <?php $primo_item=1 ?>
           <td style="width: 80px;"><div style="width: 39px; height: 53px; background-color: #4e8480; background-image: url(http://openparlamento.stage.htrex.keybit.net/email/imgs/bg-news-time.png); background-repeat: no-repeat; background-position: top left; color: #fff; text-align: center;">
	    <strong style="display: block; font-size:16px; padding-top: 6px;"><?php echo date("d", $date_ts); ?></strong>
            <strong style="display: block; font-size:10px;"><?php echo strftime("%b", $date_ts); ?></strong>
            <strong style="display: block;"><?php echo date("Y", $date_ts); ?></strong>
          </div>
          </td> 
          <?php else: ?>
            <?php $primo_item=1 ?>
           <td style="width: 80px;"><div style="width: 39px; height: 53px; background-color: #4e8480; background-image: url(http://openparlamento.stage.htrex.keybit.net/email/imgs/bg-news-time.png); background-repeat: no-repeat; background-position: top left; color: #fff; text-align: center;">
           <strong style="display: block; font-size:16px; padding-top: 6px;">NO</strong>
           <strong style="display: block; font-size:10px;">data</strong>
           <strong style="display: block;"></strong>
          </div>  
          </td> 
          <?php endif ?>
          
         
          
      
      <?php foreach ($news as $n): ?> 
      <?php if($primo_item==0) echo "<td>&nbsp;</td>" ?>

     
     
        <?php echo news_text($n,$context) ?> 
        <?php $primo_item=0 ?>
      </tr>  
      <?php endforeach ?>
      
    
  <?php endforeach; ?>
</table>
