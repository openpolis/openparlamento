<?php echo use_helper('DeppNews', 'Date'); ?>

<?php 
  $df = new sfDateFormat('it_IT'); 
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

    <?php foreach ($news as $i => $n): ?>
      <tr>     
        <?php if( $i = 0 ): ?>
          <?php if ($date_ts > 0): ?>
            <td style="width: 80px;">
                <div style="width: 39px; height: 53px; background-color: #4e8480; background-image: url(http://<?php echo $sf_site_url?>/images/bg-news-time.png); background-repeat: no-repeat; background-position: top left; color: #fff; text-align: center;">
                  <strong style="display: block; font-size:16px; padding-top: 6px;"><?php echo $df->format($date_ts, 'dd'); ?></strong>
                  <strong style="display: block; font-size:10px;"><?php echo $df->format($date_ts, 'MMM'); ?></strong>
                  <strong style="display: block;"><?php echo $df->format($date_ts, 'yyyy'); ?></strong>
                </div>
            </td>    
          <?php else: ?>
            <td style="width: 80px;">
                <div class="news-time">
                  <strong style="display: block; font-size:16px; padding-top: 6px;">NO</strong>
                  <strong style="display: block; font-size:10px;">data</strong>
                  <strong style="display: block;"> </strong>
                </div>
            </td>      
          <?php endif ?>
        <?php else: ?>
          <td>&nbsp;</td>
        <?php endif; ?>
        <?php echo news_text_for_mail($n,1,1) ?> 
      </tr>  
    <?php endforeach ?>
      
  <?php endforeach; ?>
</table>