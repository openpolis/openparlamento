<?php echo use_helper('PagerNavigation', 'DeppNews'); ?>


<?php echo include_component('monitoring', 'submenu', array('current' => 'news')); ?>


<div class="tabbed-orange float-container" id="content">
	<div id="main">

		<div class="W25_100 float-right">
			<form id="search-ddl" action="#">
				<h6>nelle tue notizie</h6>
				<fieldset id="search-ddl-fbox">
					<input type="text" class="blur" id="search-ddl-field"/>
					<input type="image" alt="cerca" src="imgs/btn-cerca-small.png" id="search-ddl-go"/>
					<div class="search-ddl-type-container">
						<div style="display: none;" id="search-ddl-type">
							<input type="radio" checked="checked" value="0" id="search-ddl-0" name="search-ddl-type"/>
							<label class="focus" for="search-ddl-0">tutto</label><br/>
							<input type="radio" value="1" id="search-ddl-1" name="search-ddl-type"/>
							<label for="search-ddl-1">codice DDL</label><br/>
							<input type="radio" value="2" id="search-ddl-2" name="search-ddl-type"/>
							<label for="search-ddl-2">titolo DDL</label><br/>
							<input type="radio" value="3" id="search-ddl-3" name="search-ddl-type"/>
							<label for="search-ddl-3">descrizione</label><br/>
							<input type="radio" value="4" id="search-ddl-4" name="search-ddl-type"/>
							<label for="search-ddl-4">teseo</label><br/>
							<input type="radio" value="5" id="search-ddl-5" name="search-ddl-type"/>
							<label for="search-ddl-5">cofirmatari e relatori</label><br/>					
						</div>
					</div>						
				</fieldset>
			</form>			
		</div>
			
	  <div class="W73_100 float-left">

      <?php include_partial('newsFilter',
                            array('tags' => $all_monitored_tags,
                                  'types' => $all_monitored_acts_types, 
                                  'selected_tag_id' => array_key_exists('tag_id', $filters)?$filters['tag_id']:'0',
                                  'selected_act_type_id' => array_key_exists('act_type_id', $filters)?$filters['act_type_id']:'0',
                                  'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:'0',
                                  'selected_date' => array_key_exists('date', $filters)?$filters['date']:'0',
                                  'selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>

								
	  </div>

	  <div class="W100_100 float-left">
	
	    <h5 class="grey-888">hai raccolto <big><?php echo $pager->getNbResults() ?></big> notizie:</h5>

    	<div class="more-results float-container">			
    		<ul>
          <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
            <li>
              <h6><?php echo date("d/m/Y", $date_ts); ?></h6>
              <ul class="square-bullet">
              <?php foreach ($news as $n): ?>
                <li><?php echo news_text($n) ?></li>
              <?php endforeach ?>
              </ul>
            </li>
          <?php endforeach; ?>
    		</ul>
    	</div>

      <?php echo pager_navigation($pager, 'monitoring/news') ?>
      
    </div>

  </div>
</div>

	
