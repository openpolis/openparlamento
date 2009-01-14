<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">

  <div id="main">
    <div class="W25_100 float-right">
      <p class="last-update">data di ultimo aggiornamento: <strong>dd-mm-yyyy</strong></p>			

      <?php echo include_partial('atto/searchbox', array()); ?>

      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Disegni di legge', 
                                       'all_news_url' => '@news_attiDisegni',
                                       'n_news' => NewsPeer::countNewsForDDLList(), 
                                       'news'   => NewsPeer::getNewsForDDLList(10))); ?>

	  </div>

    <div class="W73_100 float-left">
      <?php include_partial('disegnoWiki') ?>      		

      <?php include_partial('disegnoFilter') ?>

      <?php include_partial('disegnoSort') ?>
   
      <?php include_partial('disegnoList', array('pager' => $pager)) ?>
    </div>

    <div class="clear-both"></div>
  </div>
</div>