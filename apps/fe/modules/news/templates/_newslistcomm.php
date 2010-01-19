<ul>
<?php foreach ($latest_activities as $activity): ?>
  <?php $news_text = community_news_text($activity); ?>
  <?php if ($news_text != ''): ?>
    <li class="float-container">
      <div class="date"> <?php echo $activity->getCreatedAt("d/m/Y H:i"); ?></div>							
      <?php echo $news_text ?>
    </li>         
  <?php endif ?>
<?php endforeach; ?>
</ul>

<div class="section-box-scroller tools-container has-next">
   <?php echo link_to('<strong>vedi le ultime 100 attivit&agrave;</strong>','@news_comunita',array('class' => 'see-all')) ?>
</div> 