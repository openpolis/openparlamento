<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'decrleg')) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <!-- 
      <p class="last-update">data di ultimo aggiornamento: <strong><?php echo $last_updated_item->getDataAgg('d-m-Y') ?></strong></p>			
      -->

      <?php 
        echo include_partial('sfLucene/specialized_controls', 
                            array('query' => $query, 
                                  'type' => 'decrleg', 
                                  'title' => 'nei decreti legislativi'));
      ?>

      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Decreti legislativi', 
                                       'all_news_url' => '@news_attiDecretiLegislativi',
                                       'news'   => NewsPeer::getAttiListNews(NewsPeer::ATTI_DECRETI_LEGISLATIVI_TIPO_IDS, 10))); ?>
	  </div>
    <div class="W73_100 float-left">
      <?php include_partial('decretoLegislativoWiki') ?>

      <?php include_partial('decretoLegislativoFilter',
                            array('tags_categories' => $all_tags_categories,
                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                  'selected_act_type' => array_key_exists('act_type', $filters)?$filters['act_type']:0)) ?>

      <?php include_partial('decretoLegislativoSort') ?>

      <?php include_partial('decretoLegislativoList', array('pager' => $pager)) ?>  
    </div>
    <div class="clear-both"></div>
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  decreti legislativi
<?php end_slot() ?>