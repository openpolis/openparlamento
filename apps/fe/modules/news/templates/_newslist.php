<ul>
  <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
    <li>
      <h6>
      <?php if ($date_ts > 0): ?>
        <?php echo date("d/m/Y", $date_ts); ?>
      <?php else: ?>
        nessuna data
      <?php endif ?>
      </h6>
      <ul class="square-bullet">
      <?php foreach ($news as $n): ?>
        <li><?php echo news_text($n) ?></li>
      <?php endforeach ?>
      </ul>
    </li>
  <?php endforeach; ?>
</ul>