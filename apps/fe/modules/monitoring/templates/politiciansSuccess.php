<?php echo use_helper('I18N'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'politicians')); ?>

<div id="content" class="tabbed-orange float-container">
  <div id="main">

		<p class="tools-container"><a class="ico-help" href="#">eventuale testo micro-help</a></p>
		<div style="display: none;" class="help-box float-container">
			<div class="inner float-container">

				<a class="ico-close" href="#">chiudi</a><h5>eventuale testo micro-help ?</h5>
				<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
			</div>
		</div>

    <?php if (count($monitored_politicians)): ?>
    	<h5 class="subsection">i politici che stai monitorando</h5>
    <?php else: ?>
      Non stai monitorando nessun politico      
    <?php endif ?>
  

    <table class="list-table column-table">
  		<thead>
  			<tr>
  				<th class="evident" scope="col"><br/>parlamentare:</th>
  				<th class="evident W20_100" scope="col"><br/>notizie relative (<?php echo image_tag("ico-new.png", array('alt' => 'nuovo'))?>):</th>
  				<th class="evident W20_100" scope="col"><br/>smetti di monitorare:</th>
				</tr>
  		</thead>
  		<tbody>
  	  <?php foreach ($monitored_politicians as $politician): ?>  		  
  			<tr id="pol_<?php echo $politician->getId();?>">
  				<th scope="row"><p class="politician-id">
  				  <?php echo image_tag(OppPoliticoPeer::getThumbUrl($politician->getId()), 
                                 'icona parlamentare') ?>
  				  <?php echo link_to($politician, '@parlamentare?id='.$politician->getId()); ?></p>
  				</th>
  				<td><p class="float-right"><a class="btn-open-table action" href="#">
  				  <?php echo format_number_choice( 
              '[0]|[1]1 nuova|(1,+Inf]%1% nuove', 
              array('%1%' => $politician->getNNewNews($sf_user->getAttribute('last_login', null, 'subscriber'))),
              $politician->getNNewNews($sf_user->getAttribute('last_login', null, 'subscriber'))) 
            ?> 
            - ultima: <?php echo $politician->getLastNews()->getDate('d/m/Y') ?> 
  				</a></p></td>
  				<td>
            <!-- rimozione dal monitoraggio -->
            <?php echo link_to('x', 
                               'monitoring/removeItemFromMyMonitoredItems?item_model=OppPolitico&item_pk=' .
                                $politician->getPrimaryKey(),
                               array('class' => 'ico-stop_monitoring')) ?>
  				</td>
  			</tr>
  			<tr>
  				<td colspan="2">
  					<div style="display: none;" class="news-parlamentari float-container"> 
  					</div>				
  				</td>
  				<td/>
  			</tr>
      <?php endforeach ?>
  		</tbody>
  	</table>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  i tuoi parlamentari
<?php end_slot() ?>


<!-- slider jQuery per le notizie relative ai politici -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($){
  $(document).ready(function($){
  	// Visualizza/nascondi liste in tabella
  	$('.btn-open-table').click(
  		function(){
        $this = $(this);
  			var line = $this.toggleClass('btn-open-table').toggleClass('btn-close-table').parents('tr');
        var id = $(line).get(0).id.split('_').pop();
        var url = "<?php echo url_for('monitoring/ajaxNewsForItem'); ?>";
        if (!$this.data('news_loaded'))
        {
          $.get(url, { item_id: id, item_model: 'OppPolitico', all_news_route: '@news_parlamentare' },
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
