<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <li><?php echo link_to('pagina di ' . $politician, '@parlamentare?id='.$politician_id) ?></li>
            <?php if ($sf_user->isAuthenticated()): ?>
              <li><?php echo link_to('i parlamentari monitorati', 'monitoring/politicians') ?></li>              
            <?php endif ?>
          </ul>
        </div>
      </div>      
    </div>
    
    <h3>Tutte le notizie relative a <?php echo $politician ?></h3>

    Dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>
    di <?php echo $pager->getNbResults() ?><br/>

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

    <?php echo pager_navigation($pager, '@news_parlamentare?id='.$politician_id, true, 7) ?>

  </div>
</div>