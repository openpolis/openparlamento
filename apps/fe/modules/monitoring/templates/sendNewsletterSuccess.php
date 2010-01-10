<?php echo use_helper('DeppNews', 'Date'); ?>

<?php 
  $sf_site_url = sfConfig::get('sf_site_url', 'openparlamento');
?>

<table width="100%" cellpadding="0" cellspacing="0" style="color: #626262; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
    <tr>
        <td style="width: 190px;"><img src="http://<?php echo $sf_site_url?>/images/OP_mail.png" alt="Openparlamento" width="190" height="56" /></td>
        <td style="background-color: #fff; background-image: url(http://<?php echo $sf_site_url?>/images/header_bg.png); background-repeat: repeat-x; background-position: top left;"><img src="http://<?php echo $sf_site_url?>/images/header_bg.png" width="100%" height="56"/></td>
        <td style="width: 109px;"><img src="http://<?php echo $sf_site_url?>/images/Openpolisl.png" alt="e' uno strumento Openpolis" width="109" height="56" /></td>
    </tr>
</table>


<h2 style="color: #626262; font-family: Arial, Helvetica, sans-serif; padding-left: 12px; font-size: 20px;">Le ultime notizie</h2>

<table style="width: 100%; vertical-align: top; margin-bottom: 20px; color: #626262; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
  
  <?php foreach ($grouped_news as $date_ts => $news): ?>
    <tr><td colspan="3">&nbsp;</td></tr>

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
            <?php include_partial('news/dateboxmail', array('date_ts' => $date_ts, 
                                                            'date_format' => new sfDateFormat('it_IT'))) ?>
          </td> 
        <?php else: ?>
          <td>&nbsp;</td>
        <?php endif; ?>
        
        <!-- news icon -->
        <?php 
          $icon_src = image_tag(news_icon_name($generator_model, $generator), 
                                array('size' => '44x42', 
                                      'absolute' => true)) 
        ?>
        <td class="icon-id" style="width: 60px;">
          <img style="border:none; display: block; border: none; background: transparent url(http://<?php echo $sf_site_url?>/images/bg-ico-type.png) no-repeat top left; height: 50px; padding: 4px 0 0 3px;" src="<?php echo $icon_src?>" />
        </td>
        
        <!-- news text -->
        <td>
          <?php echo news_text($n, $generator_model, $pks, $generator, 
                               array('in_mail' => true)) ?>
        </td>
        
      </tr>
    <?php endforeach ?>
      
  <?php endforeach; ?>
</table>