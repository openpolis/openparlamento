<?php echo use_helper('PagerNavigation', 'DeppNews', 'Date'); ?>
<?php setlocale(LC_TIME,"it_IT") ?>


<?php echo include_component('monitoring', 'submenu', array('current' => 'news')); ?>

<div class="row">
	<div class="twelvecol">
		
		<?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>    
	          <div style="width:40%; font-size:14px; line-height:1.2em; border:1px solid #EE7F00; padding:5px;" ><strong>Promuovi la trasparenza e la partecipazione!</strong><br /><?php echo link_to('Prenota la tua tessera 2010 all\'associazione openpolis','@tesseramento') ?>
	      </div>
	      <?php endif; ?>
	
		<?php include_partial('newsFilter',
	                            array('tags' => $all_monitored_tags,
	                                  'types' => $all_monitored_acts_types, 
	                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_diff(array_values($filters), array('main', 'all'))),
	                                  'selected_tag_id' => array_key_exists('tag_id', $filters)?$filters['tag_id']:'0',
	                                  'selected_act_type_id' => array_key_exists('act_type_id', $filters)?$filters['act_type_id']:'0',
	                                  'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:'0',
	                                  'selected_date' => array_key_exists('date', $filters)?$filters['date']:'0',
	                                  'selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>
		
	</div>
</div>

<div class="row">
	<div class="twelvecol">
		
		<h5 class="grey-888">
	      hai raccolto <big><?php echo $pager->getNbResults() ?></big> notizie:
	      <?php if (deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values(array_diff_key($filters, array('main_all' => ''))))): ?>
          <?php echo link_to('rimuovi i filtri',  
                             '@monitoring_news?user_token=' .$sf_user->getToken(). '&reset_filters=true') ?>
        <?php endif ?>        
	    </h5>
	    
      <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS')), 
                         '@feed_user_news?token=' . $sf_user->getToken(), 
                         array('style' => 'float:right', 'target' => '_blank')) ?>      
      


      <?php echo include_partial('news/newslist', array('pager' => $pager, 'context' => CONTEXT_LIST)); ?>

      <?php echo pager_navigation($pager, 'monitoring/news') ?>
      <div style="margin: 1em 0; text-align: center">
        <?php echo link_to('Scarica questo elenco in formato RSS', '@feed_user_news?token=' . $sf_user->getToken(), 
                           array('target' => '_blank')) ?>        
      </div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  le mie notizie
<?php end_slot() ?>