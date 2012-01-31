<?php use_helper('I18N', 'Date') ?>

<div class="row">
	<div class="twelvecol">
		<?php include_partial('tabs', array('current' => 'nonleg')) ?>
	</div>
</div>

<div class="row">
	
	<div class="ninecol">
		<?php include_partial('attoNonLegislativoWiki') ?>  	  		

	      <?php include_partial('attoNonLegislativoFilter',
	                            array('tags_categories' => $all_tags_categories,
	                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
	                                  'selected_act_type' => array_key_exists('act_type', $filters)?$filters['act_type']:0,                                
	                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
	                                  'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:0,
	                                  'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

	      <?php include_partial('attoNonLegislativoSort') ?>

	      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

	      <?php include_partial('attoNonLegislativoList', array('pager' => $pager)) ?>
	</div>
	
	<div class="threecol last">
		<!-- 
	      <p class="last-update">data di ultimo aggiornamento: <strong><?php echo $last_updated_item->getDataAgg('d-m-Y') ?></strong></p>			
	      -->

	      <?php 
	        echo include_partial('sfSolr/specialized_controls', 
	                            array('query' => $query, 
	                                  'type' => 'nonleg', 
	                                  'title' => 'negli atti non legislativi'));
	      ?>


	      <?php echo include_partial('news/newsbox', 
	                                 array('title' => 'Atti non legislativi', 
	                                       'all_news_url' => '@news_attiNonLegislativi',
	                                       'news'   => oppNewsPeer::getAttiListNews(oppNewsPeer::ATTI_NON_LEGISLATIVI_TIPO_IDS, 10),
	                                       'context' => 1,
	                                       'rss_link' => '@feed_attiNonLegislativi')); ?>
	</div>
	
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  atti non legislativi
<?php end_slot() ?>