<div style="width: 39px; height: 53px; background-color: #4e8480; background-image: url(http://<?php echo $sf_site_url?>/images/bg-news-time.png); background-repeat: no-repeat; background-position: top left; color: #fff; text-align: center;">
  <?php if ($date_ts > 0): ?>
    <strong style="display: block; font-size:16px; padding-top: 6px;"><?php echo $date_format->format($date_ts, 'dd'); ?></strong>
    <strong style="display: block; font-size:10px;"><?php echo $date_format->format($date_ts, 'MMM'); ?></strong>
    <strong style="display: block;"><?php echo $date_format->format($date_ts, 'yyyy'); ?></strong>
  <?php else: ?>
    <strong style="display: block; font-size:16px; padding-top: 6px;">NO</strong>
    <strong style="display: block; font-size:10px;">data</strong>
    <strong style="display: block;"> </strong>
  <?php endif ?>
</div>
