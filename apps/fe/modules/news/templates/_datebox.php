<div class="news-time">
  <?php if ($date_ts > 0): ?>
    <strong class="day"><?php echo $date_format->format($date_ts, 'dd'); ?></strong>
    <strong class="month"><?php echo $date_format->format($date_ts, 'MMM'); ?></strong>
    <strong class="year"><?php echo $date_format->format($date_ts, 'yyyy'); ?></strong>
  <?php else: ?>
    <strong class="day">NO</strong>
    <strong class="month">data</strong>
    <strong class="year"></strong>
  <?php endif ?>
</div> 
