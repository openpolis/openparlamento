<?php use_helper('I18N', 'Date') ?>
<?php echo include_component('monitoring', 'submenu', array('current' => 'acts')); ?>

<div class="row">
	<div class="twelvecol">
		
		<p class="tools-container"><a class="ico-help" href="#">cosa sono gli atti preferiti</a></p>
	  		<div style="display: none;" class="help-box float-container">
	  			<div class="inner float-container">

	  				<a class="ico-close" href="#">chiudi</a><h5>cosa sono gli atti preferiti ?</h5>
	  				<p>Gli atti prefereti sono quelli che tu hai segnalato come importanti</p>
	  			</div>
	  		</div>

	    <h5 id="type_<?php echo $type_id;?>"class="subsection">I tuoi atti preferiti</h5>
	    <div class="show-all-results">
	    <?php echo link_to('<strong>mostra tutti gli atti monitorati</strong>', 
	                       '@monitoring_acts?user_token='.$sf_user->getToken(), 
	                       array('post' => true)); ?>
	    </div>  
	    <table class="list-table column-table">
			<thead>
				<tr>
				        <th class="evident" scope="col">aggiungi o rimuovi<br/>dai preferiti:</th>
					<th class="evident" scope="col"><br/>sigla/titolo:</th>
					<th class="evident" scope="col">stato di avanzamento</th>
					<th class="evident" scope="col">argomenti</th>
					<th class="evident W20_100" scope="col"><br/>notizie relative (<?php echo image_tag('ico-new.png', array('alt' => 'nuovo', 'width' => '18', 'height' => '10')) ?>):</th>
					<th class="evident" scope="col">il tuo voto:</th>
				</tr>
			</thead>
			<tbody>
	                <?php foreach ($favourite_acts as $act): ?>
	                  <?php  echo include_component('monitoring', 'actLine', 
	                                                array('act' => $act, 
	                                                      'user' => $user, 
	                                                      'user_id' => $user_id,
	                                                      'user_voting_act' => $act->getUserVoting($user_id))); ?>
	                  <?php endforeach ?>        
	                </tbody>
	      </table>
		
	</div>
</div>

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
