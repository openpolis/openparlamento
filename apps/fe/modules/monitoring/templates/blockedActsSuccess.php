<?php use_helper('I18N', 'Date') ?>
<?php echo include_component('monitoring', 'submenu', array('current' => 'acts')); ?>

<div class="row">
	<div class="twelvecol">
		
		<p class="tools-container"><a class="ico-help" href="#">cosa sono gli atti scartati</a></p>
	  		<div style="display: none;" class="help-box float-container">
	  			<div class="inner float-container">

	  				<a class="ico-close" href="#">chiudi</a><h5>cosa sono gli atti scartati ?</h5>
	  				<p>Gli atti scartati sono quegli associati a un determinato argomento che stai monitorando, che hai scelto di non seguire.<br />
	  				</p>
	  			</div>
	  		</div>

	    <h5 id="type_<?php echo $type_id;?>"class="subsection">Elenco degli atti scartati</h5>
	    <div class="show-all-results">
	    <?php echo link_to('<strong>mostra tutti gli atti monitorati</strong>', 
	                       '@monitoring_acts?user_token='.$sf_user->getToken(), 
	                       array('post' => true)); ?>
	    </div>  

	    <table class="list-table column-table">
			<thead>
				<tr>
				        <th class="evident" scope="col"></th>
					<th class="evident" scope="col"><br/>sigla/titolo:</th>
					<th class="evident" scope="col">stato di avanzamento</th>
					<th class="evident" scope="col">argomenti</th>
					<th class="evident W20_100" scope="col"><br/>notizie relative (<?php echo image_tag('ico-new.png', array('alt' => 'nuovo')) ?>):</th>
					<th class="evident" scope="col">il tuo voto:</th>
					<th class="evident" scope="col">aggiungi ai monitorati</th>
				</tr>
			</thead>
			<tbody>
	        <?php foreach ($blocked_acts as $act): ?>
	          <?php  echo include_component('monitoring', 'actLine', 
	                                       array('act' => $act, 'user' => $user, 'user_id' => $user_id, 'user_voting_act' => $act->getUserVoting($user_id))); ?>

	        <?php endforeach ?>        
	      </tbody>
	      </table>
		
	</div>
</div>

<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript" language="javascript">
//<![CDATA[

jQuery.noConflict();
(function($){
  
  // news cached-slider (only does ajax request once)
  $('.monitored_acts .acts li span.title').click( function(){
    $this = $(this);
    var id = $this.parent().get(0).id.split('_').pop();
    var url = "<?php echo url_for('monitoring/ajaxNewsForAct'); ?>";
    if (!$this.data('news_loaded'))
    {
      $.get(url, { act_id: id },
        function(data){
          $this.parent().append('<div class="news">' + data + '</div>').css('display', 'none').slideDown();
          $this.data('news_loaded', true);
          $this.unbind('click').click( function(){
            $(this).parent().find("div.news").slideToggle("slow");
          });
        })      
    }
      
  });  
})(jQuery);


//]]>
</script>
