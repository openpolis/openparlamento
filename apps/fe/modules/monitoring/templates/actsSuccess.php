<?php use_helper('I18N', 'Date') ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'acts')); ?>

<div class="row">
	<div class="twelvecol">
		
		<?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>    
	<div style="width:40%; font-size:14px; line-height:1.2em; border:1px solid #EE7F00; padding:5px;" ><strong>Promuovi la trasparenza e la partecipazione!</strong><br /><?php echo link_to('Prenota la tua tessera 2010 all\'associazione openpolis','@tesseramento') ?>
	        </div>
	        <?php endif; ?>

	  		<p class="tools-container"><a class="ico-help" href="#">Come posso monitorare un atto</a></p>
	  		<div style="display: none;" class="help-box float-container">
	  			<div class="inner float-container">

	  				<a class="ico-close" href="#">chiudi</a><h5>Come posso monitorare un atto? ?</h5>
	  				<p>Nella pagina di ogni atto (disegno di legge, decreto, mozione, interrogazione, etc.) in alto a destra trovi il bottone che ti permette di avviare il monitoraggio, contrassegnata dalla icona della lente di ingrandimento. Una volta scelto di seguire un atto riceverai tutte le notizie e informazioni relative - ogni volta che ce ne saranno - sia nelle tue pagine personali del "monitoraggio" ("le mie notizie" - "i miei atti") che nella tua casella e-mail attraverso la "newsletter" . Per smettere di monitorare l'atto &egrave; sufficiente andare nella pagina dell'atto dove in alto a destra si trova il bottone "smetti di monitorare". La stessa funzione &egrave; disponibile anche nella pagina "i miei atti" dove per ciascun atto elencato &egrave; disponibile il bottone "smetti di monitorare" (icona della crocetta rossa accanto la lente di ingrandimento).</p>
	  			</div>
	  		</div>

	      <?php include_partial('actsFilter',
	                            array('tags' => $all_monitored_tags,
	                                  'types' => $all_monitored_acts_types, 
	                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
	                                  'selected_tag_id' => array_key_exists('tag_id', $filters)?$filters['tag_id']:0,
	                                  'selected_act_type_id' => array_key_exists('act_type_id', $filters)?$filters['act_type_id']:0,                                
	                                  'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:0,
	                                  'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>


	    	<div class="float-container tools-container" id="disegni-decreti-order">
	    		<p>mostra solo</p>
	    		<ul>
	    			<li><?php echo link_to(image_tag('/images/ico-star-on.png',array()).' i tuoi atti preferiti', 'monitoring/favouriteActs') ?></li>		
	    			<li><?php echo link_to(image_tag('/images/ico-stop_monitoring.png',array()).'<i> gli atti che hai scartato</i>', 'monitoring/blockedActs') ?></li>

	    		</ul>
	    	</div>


	      <?php if (deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters))): ?>
	        <?php echo link_to('rimuovi i filtri',  
	                           '@monitoring_acts?user_token=' .$sf_user->getToken(). '&reset_filters=true') ?>
	      <?php endif ?>        

	      <?php foreach ($monitored_acts_types as $type): ?>
	        <?php echo include_component('monitoring', 'actsForType', 
	                                     array('user' => $user, 'user_id' => $user_id,
	                                           'my_monitored_tags_pks' => $my_monitored_tags_pks,
	                                           'type' => $type,
	                                           'filters' => $filters,
	                                           'tag_filtering_criteria' => $tag_filtering_criteria)); ?>
	      <?php endforeach ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  i miei atti
<?php end_slot() ?>



<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $(document).ready(function(){
  
    // acts slider
    $('.type').click( function(){
      var id = $(this).get(0).id.split('_').pop();
      $(this).parent().find("#type_acts_" + id).slideToggle("slow");
    });

  	// preferiti
  	$('.ico-star').click(
  		function(){
  			$(this).toggleClass('bookmark');
  			// return false;
  		}
  	);


  	// Visualizza/nascondi liste in tabella
  	$('.btn-open-table').click(
  		function(){
        $this = $(this);
  			var line = $this.toggleClass('btn-open-table').toggleClass('btn-close-table').parents('tr');
        var id = $(line).get(0).id.split('_').pop();
        var url = "<?php echo url_for('monitoring/ajaxNewsForItem'); ?>";
        if (!$this.data('news_loaded'))
        {
          $.get(url, { item_id: id, item_model: 'OppAtto', all_news_route: '@news_atto' },
            function(data){
              $(line).next().find('.news-parlamentari').append(data).css('display', 'none').slideDown();
              $this.data('news_loaded', true);
              $this.unbind('click').click( function(){
                $(line).next().find(".news-parlamentari").toggle();
                $this.toggleClass('btn-open-table').toggleClass('btn-close-table');
                return false;
              });
            })      
        }
  			return false; 
  		}
  	);
  })
})(jQuery);


//]]>
</script>
