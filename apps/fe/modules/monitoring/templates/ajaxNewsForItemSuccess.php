<?php echo use_helper('DeppNews'); ?>
<?php setlocale(LC_TIME,"it_IT") ?>


<table class="table-news">
  <?php foreach ($grouped_news as $date_ts => $news): ?>
    <tr class="data"><td colspan="3"></td></tr>
      
      <?php foreach ($news as $cnt => $n): ?> 
        <?php
        
        // fetch del modello e dell'oggetto che ha generato la notizia
        $generator_model = $n->getGeneratorModel();
        if ($n->getGeneratorPrimaryKeys())
        {
          $pks = array_values(unserialize($n->getGeneratorPrimaryKeys()));
          $generator = call_user_func_array(array($generator_model.'Peer', 'retrieveByPK'), $pks);   
        } else {
          $pks = array();
          $generator = null;
        }
        
        ?>
        <tr>
          <!-- datebox cell / empty -->
          <?php if ($cnt == 0): ?>
            <td style="width: 80px;">
              <div class="news-time">
                <?php if ($date_ts > 0): ?>
      	          <strong class="day" style="padding-left:0px; color:#FFFFFF;text-align:center;"><?php echo date("d", $date_ts); ?></strong>
                  <strong class="month" style="padding-left:0px; color:#FFFFFF;text-align:center;"><?php echo strftime("%b", $date_ts); ?></strong>
                  <strong class="year" style="padding-left:0px; color:#FFFFFF;text-align:center;"><?php echo date("Y", $date_ts); ?></strong>
                <?php else: ?>
                  <strong class="day" style="padding-left:0px; color:#FFFFFF;text-align:center;">NO</strong>
                  <strong class="month" style="padding-left:0px; color:#FFFFFF;text-align:center;">data</strong>
                  <strong class="year" style="padding-left:0px; color:#FFFFFF;text-align:center;"></strong>
                <?php endif ?>
              </div> 
            </td> 
          <?php else: ?>
            <td>&nbsp;</td>
          <?php endif; ?>
          
          <!-- news icon -->
          <td class="icon-id" style="width: 60px;">
            <?php echo image_tag(news_icon_name($generator_model, $generator), 
                                 array('size' => '44x42', 
                                       'absolute' => false)) ?>
          </td>
          
          <!-- news text -->
          <td>
            <?php echo news_text($n, $generator_model, $pks, $generator, array('context' => 1)) ?>
          </td>
          
        </tr>
      <?php endforeach ?>
    
  <?php endforeach; ?>
</table>



<?php if ($has_more>0): ?>
  <?php echo link_to("visualizza tutte le $has_more notizie", $all_news_route.'?id='.$item_id, 
                     array('class' => 'see-all tools-container')) ?>
<?php endif ?>