<?php echo use_helper('PagerNavigation', 'DeppNews', 'Date'); ?>
<?php setlocale(LC_TIME,"it_IT") ?>


<?php echo include_component('monitoring', 'submenu', array('current' => 'news')); ?>


<div class="tabbed-orange float-container" id="content">
	<div id="main">
  
    <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>    
    <div style="width:40%; font-size:14px; line-height:1.2em; border:1px solid #EE7F00; padding:5px;" >Approfitta subito della <strong>promozione gratuita valida fino al 30 novembre 2009</strong>: diventa un utente premium di openparlamento.<br /> <strong><?php echo link_to('Scopri il servizio premium e aderisci gratuitamente!','http://parlamento.openpolis.it/sottoscrizioni_pro') ?> </strong>
      </div>
      <?php endif; ?>

	  <div class="W73_100 float-left">
  		

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

	  <div class="W100_100 float-left">
	
	    <h5 class="grey-888">
	      hai raccolto <big><?php echo $pager->getNbResults() ?></big> notizie:
	      <?php if (deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values(array_diff_key($filters, array('main_all' => ''))))): ?>
          <?php echo link_to('rimuovi i filtri',  
                             '@monitoring_news?user_token=' .$sf_user->getToken(). '&reset_filters=true') ?>
        <?php endif ?>        
	    </h5>


       <table class="table-news">
          <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
            <?php $primo_item=1 ?>
            <?php echo ($primo_item==1 ? '<tr class="data"><td>&nbsp;</td></tr>' : '') ?>
	      <tr>
	      <?php if ($date_ts > 0): ?>
	             <?php $primo_item=1 ?>
	           <td style="width: 80px;">
	           <div class="news-time">
               <?php $df = new sfDateFormat('it_IT'); ?>
               <strong class="day"><?php echo $df->format($date_ts, 'dd'); ?></strong>
               <strong class="month"><?php echo $df->format($date_ts, 'MMM'); ?></strong>
               <strong class="year"><?php echo $df->format($date_ts, 'yyyy'); ?></strong>
	          </div> 
	          </td> 
	          <?php else: ?>
	            <?php $primo_item=1 ?>
	           <td style="width: 80px;">
	           <div class="news-time">
	           <strong class="day">NO</strong>
	           <strong class="month">data</strong>
	           <strong class="year"></strong>
	          </div>  
	          </td> 
	          <?php endif ?>
          
         
              <?php foreach ($news as $n): ?>
                <?php if($primo_item==0) echo "<tr><td>&nbsp;</td>" ?>
                 <?php echo news_text($n,3) ?>
                <?php $primo_item=0 ?>
                </tr>  
              <?php endforeach ?>
              
         <?php endforeach; ?>
       </table>

      <?php echo pager_navigation($pager, 'monitoring/news') ?>
      
    </div>

  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  le mie notizie
<?php end_slot() ?>