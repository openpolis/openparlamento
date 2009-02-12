<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'decreti')) ?>

<div id="content" class="tabbed float-container">
  <div id="main">

    <div class="W25_100 float-right">
      <!-- 
      <p class="last-update">data di ultimo aggiornamento: <strong><?php echo $last_updated_item->getDataAgg('d-m-Y') ?></strong></p>			
      -->
      
      <?php 
        echo include_partial('sfLucene/specialized_controls', 
                            array('query' => $query, 
                                  'type' => 'decreti', 
                                  'title' => 'nei decreti legge'));
      ?>


      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Decreti legge', 
                                       'all_news_url' => '@news_attiDecreti',
                                       'news'   => NewsPeer::getAttiListNews(NewsPeer::ATTI_DECRETI_TIPO_IDS, 10))); ?>
	  </div>

    <div class="W73_100 float-left">
      <?php include_partial('decretoWiki') ?>  		

      <?php include_partial('decretoFilter',
                            array('tags_categories' => $all_tags_categories,
                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                  'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

      <?php include_partial('decretoSort') ?>
     
      <?php include_partial('decretoList', array('pager' => $pager)) ?> 
    </div>

    <div class="clear-both"></div>

  </div>
</div>