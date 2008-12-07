<?php echo use_helper('DeppNews'); ?>
<ul>
  <?php foreach ($news as $n): ?>
    <li id="news_<?php echo $n->getId()?>" 
        class="<?php echo date('U', strtotime($n->getCreatedAt())) > date('U', strtotime($sf_user->getAttribute('last_login', null, 'subscriber')))?'new':''?>">
      <?php echo news($n); ?>
    </li>
  <?php endforeach ?>
  <?php if ($has_more>0): ?>
    <li><?php echo link_to("visualizza tutte le $has_more notizie", '@news_atto?id=' . $act_id) ?></li>
  <?php endif ?>
</ul>

