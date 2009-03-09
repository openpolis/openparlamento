<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <li><?php echo link_to('Home page', '/') ?></li>
          </ul>
        </div>
      </div>      
    </div>
    <h3>Tutte le notizie (Home)</h3>

    Dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>
    di <?php echo $pager->getNbResults() ?><br/>

    <?php echo include_partial('news/newslist', array('pager' => $pager)); ?>

    <?php echo pager_navigation($pager, 'news/homeAll') ?>

  </div>
</div>

