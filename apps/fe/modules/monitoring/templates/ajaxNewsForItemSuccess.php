<?php echo use_helper('DeppNews'); ?>

<ul>
  <?php foreach ($grouped_news as $date_ts => $news): ?>
    <?php if (count($news)>0): ?>
      <li class="news-group">
        <strong>
        <?php if ($date_ts > 0): ?>
          <?php echo date("d/m/Y", $date_ts); ?>
        <?php else: ?>
          nessuna data
        <?php endif ?>
        </strong>
        <ul class="square-bullet">
        <?php foreach ($news as $n): ?>
          <li id="news_<?php echo $n->getId()?>" 
              class="<?php echo date('U', strtotime($n->getCreatedAt())) > date('U', strtotime($sf_user->getAttribute('last_login', null, 'subscriber')))?'new':''?>">
            <?php echo news_text($n) ?>
          </li>
        <?php endforeach ?>
        </ul>
      </li>      
    <?php endif ?>
  <?php endforeach; ?>
</ul>
<?php if ($has_more>0): ?>
  <?php echo link_to("visualizza tutte le $has_more notizie", $all_news_route.'?id='.$item_id, 
                     array('class' => 'see-all tools-container')) ?>
<?php endif ?>