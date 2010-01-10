<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'disegni')) ?>

<div id="content" class="tabbed float-container">

  <div id="main">
    <div class="W25_100 float-right">
      <p class="last-update">data di ultimo aggiornamento: <strong><?php echo $last_updated_item->getDataAgg('d-m-Y') ?></strong></p>			

      <?php 
        echo include_partial('sfSolr/specialized_controls', 
                            array('query' => $query, 
                                  'type' => 'disegni', 
                                  'title' => 'nei disegni di legge'));
      ?>

      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Disegni di legge', 
                                       'all_news_url' => '@news_attiDisegni', 
                                       'news'   => oppNewsPeer::getAttiListNews(oppNewsPeer::ATTI_DDL_TIPO_IDS, 10),
                                       'context' => 1,
                                       'rss_link' => '@feed_disegni')); ?>

	  </div>

    <div class="W73_100 float-left">
        <?php include_partial('disegnoWiki') ?>      		

        <?php include_partial('disegnoFilter',
                              array('tags_categories' => $all_tags_categories,
                                    'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
                                    'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                    'selected_initiative_type' => array_key_exists('initiative_type', $filters)?$filters['initiative_type']:0,                                
                                    'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:0,
                                    'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

        <?php include_partial('disegnoSort') ?>

        <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults())); ?>
   
        <?php include_partial('disegnoList', 
                              array('pager' => $pager)) ?>
    </div>

    <div class="clear-both"></div>
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  disegni di legge
<?php end_slot() ?>