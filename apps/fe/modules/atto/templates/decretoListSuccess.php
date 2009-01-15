<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">

    <div class="W25_100 float-right">
      <p class="last-update">data di ultimo aggiornamento: <strong>dd-mm-yyyy</strong></p>			

      <?php echo include_partial('atto/searchbox', array()); ?>

      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Decreti legge', 
                                       'all_news_url' => '@news_attiDecreti',
                                       'n_news' => NewsPeer::countAttiListNews(NewsPeer::ATTI_DECRETI_TIPO_IDS), 
                                       'news'   => NewsPeer::getAttiListNews(NewsPeer::ATTI_DECRETI_TIPO_IDS, 10))); ?>
	  </div>

    <div class="W73_100 float-left">
      <?php include_partial('decretoWiki') ?>  		

      <?php include_partial('decretoFilter') ?>

      <?php include_partial('decretoSort') ?>
     
      <?php include_partial('decretoList', array('pager' => $pager)) ?> 
    </div>

    <div class="clear-both"></div>

  </div>
</div>