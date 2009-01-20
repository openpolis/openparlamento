<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <li><?php echo link_to('Atti non legislativi', '@attiNonLegislativi') ?></li>
          </ul>
        </div>
      </div>      
    </div>

    <?php include_partial('filter',
                          array('selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>
    
    <h3>Tutte le notizie relative agli atti non legislativi legislativi</h3>

    Dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>
    di <?php echo $pager->getNbResults() ?><br/>

    <?php echo pager_navigation($pager, 'news/attiNonLegislativiList') ?>

    <ul>
    <?php foreach ($pager->getResults() as $news): ?>
      <li><?php echo news($news); ?></li>
    <?php endforeach ?>
    </ul>

    <?php echo pager_navigation($pager, 'news/attiNonLegislativiList') ?>

  </div>
</div>