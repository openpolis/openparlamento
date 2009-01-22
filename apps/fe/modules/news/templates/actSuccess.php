<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <li><?php echo link_to('pagina dell\'atto ', '#') ?></li>
            <?php if ($sf_user->isAuthenticated()): ?>
              <li><?php echo link_to('DDL e Atti monitorati', 'monitoring/acts') ?></li>              
            <?php endif ?>
          </ul>
        </div>
      </div>      
    </div>
    
    <h3>Tutte le notizie relative all'atto</h3>

    Dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>
    di <?php echo $pager->getNbResults() ?><br/>

    <?php echo pager_navigation($pager, '@news_atto?id='.$act_id, true, 7) ?>

    <ul>
      <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
        <li>
          <h6><?php echo date("d/m/Y", $date_ts); ?></h6>
          <ul class="square-bullet">
          <?php foreach ($news as $n): ?>
            <li><?php echo news_text($n) ?></li>
          <?php endforeach ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php echo pager_navigation($pager, '@news_atto?id='.$act_id, true, 7) ?>

  </div>
</div>