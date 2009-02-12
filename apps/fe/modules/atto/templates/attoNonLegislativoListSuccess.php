<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'nonleg')) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <!-- 
      <p class="last-update">data di ultimo aggiornamento: <strong><?php echo $last_updated_item->getDataAgg('d-m-Y') ?></strong></p>			
      -->

      <?php 
        echo include_partial('sfLucene/specialized_controls', 
                            array('query' => $query, 
                                  'type' => 'nonleg', 
                                  'title' => 'negli atti non legislativi'));
      ?>


      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Atti non legislativi', 
                                       'all_news_url' => '@news_attiNonLegislativi',
                                       'news'   => NewsPeer::getAttiListNews(NewsPeer::ATTI_NON_LEGISLATIVI_TIPO_IDS, 10))); ?>

	  </div>

    <div class="W73_100 float-left">
      <?php include_partial('attoNonLegislativoWiki') ?>  	  		

      <?php include_partial('attoNonLegislativoFilter',
                            array('tags_categories' => $all_tags_categories,
                                  'selected_act_type' => array_key_exists('act_type', $filters)?$filters['act_type']:0,                                
                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                  'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:0,
                                  'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

      <?php include_partial('attoNonLegislativoSort') ?>

      <?php include_partial('attoNonLegislativoList', array('pager' => $pager)) ?>
    </div>

    <div class="clear-both"></div>
  </div>
</div>