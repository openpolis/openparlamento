<?php echo use_helper('DeppNews'); ?>

<table class="table-news">
  <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
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
              <?php include_partial('news/datebox', array('date_ts' => $date_ts, 
                                                          'date_format' => new sfDateFormat('it_IT'))) ?>
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
            <?php echo news_text($n, $generator_model, $pks, $generator, array('context' => $context)) ?>
          </td>
          
        </tr>
      <?php endforeach ?>
    
  <?php endforeach; ?>
</table>
