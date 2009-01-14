<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <p class="last-update">data di ultimo aggiornamento: <strong>dd-mm-yyyy</strong></p>			

      <?php echo include_partial('atto/searchbox', array()); ?>

      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Atti non legislativi', 
                                       'all_news_url' => '@news_attiNonLegislativi',
                                       'n_news' => NewsPeer::countNewsForAttiNonLegislativiList(), 
                                       'news'   => NewsPeer::getNewsForAttiNonLegislativiList(10))); ?>

	  </div>

    <div class="W73_100 float-left">
      <?php include_partial('attoNonLegislativoWiki') ?>  	  		

      <?php include_partial('attoNonLegislativoFilter') ?>

      <?php include_partial('attoNonLegislativoSort') ?>

      <?php include_partial('attoNonLegislativoList', array('pager' => $pager)) ?>
    </div>

    <div class="clear-both"></div>
  </div>
</div>