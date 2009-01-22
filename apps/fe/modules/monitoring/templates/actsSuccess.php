<?php echo include_component('monitoring', 'submenu', array('current' => 'acts')); ?>

<div id="content" class="tabbed-orange float-container">
  <div id="main">

    <div class="W100_100 float-left">
  		<p class="tools-container"><a class="ico-help" href="#">eventuale testo micro-help</a></p>
  		<div style="display: none;" class="help-box float-container">
  			<div class="inner float-container">

  				<a class="ico-close" href="#">chiudi</a><h5>eventuale testo micro-help ?</h5>
  				<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  			</div>
  		</div>

      <?php include_partial('actsFilter',
                            array('tags' => $all_monitored_tags,
                                  'types' => $all_monitored_acts_types, 
                                  'selected_tag_id' => array_key_exists('tag_id', $filters)?$filters['tag_id']:0,
                                  'selected_act_type_id' => array_key_exists('act_type_id', $filters)?$filters['act_type_id']:0,                                
                                  'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:0,
                                  'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>


    	<div class="float-container tools-container" id="disegni-decreti-order">
    		<form>
    		<p>mostra solo</p>
    		<ul>
    			<li><?php echo link_to('preferiti', 'monitoring/favouriteActs') ?></li>		
    			<li><?php echo link_to('<i>bloccati</i>', 'monitoring/blockedActs') ?></li>
    		</ul>
    		</form>
    	</div>

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
</div>



<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript" language="javascript">
//<![CDATA[

jQuery.noConflict();
(function($){
  
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
              $(line).next().find(".news-parlamentari").slideToggle("slow");
              $this.toggleClass('btn-open-table').toggleClass('btn-close-table');
              return false;
            });
          })      
      }
			return false; 
		}
	);

})(jQuery);


//]]>
</script>