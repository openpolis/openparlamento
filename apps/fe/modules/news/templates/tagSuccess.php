<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <?php if ($sf_user->isAuthenticated()): ?>
              <li><?php echo link_to('Gestione argomenti monitorati', '@monitoring_tags?user_token='.$sf_user->getToken()) ?></li>              
            <?php endif ?>
          </ul>
        </div>
      </div>      
    </div>
    
    <h3>Tutte le notizie relative all'argomento <?php echo $tag ?></h3>

    Dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>
    di <?php echo $pager->getNbResults() ?><br/>

    <?php echo pager_navigation($pager, 'news/tag?id='.$tag_id, true, 7) ?>

    <ul>
    <?php foreach ($pager->getResults() as $news): ?>
      <li><?php echo news($news); ?></li>
    <?php endforeach ?>
    </ul>

    <?php echo pager_navigation($pager, 'news/tag?id='.$tag_id, true, 7) ?>

  </div>
</div>