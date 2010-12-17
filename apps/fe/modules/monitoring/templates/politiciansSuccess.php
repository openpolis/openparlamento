<?php echo use_helper('I18N'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'politicians')); ?>

<div id="content" class="tabbed-orange float-container">
  <div id="main">
    
    <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>    
    <div style="width:40%; font-size:14px; line-height:1.2em; border:1px solid #EE7F00; padding:5px;" ><strong>Promuovi la trasparenza e la partecipazione!</strong><br /><?php echo link_to('Prenota la tua tessera 2010 all\'associazione openpolis','@tesseramento') ?>
      </div>
      <?php endif; ?>

		<p class="tools-container"><a class="ico-help" href="#">come posso monitorare un parlamentare</a></p>
		<div style="display: none;" class="help-box float-container">
			<div class="inner float-container">

				<a class="ico-close" href="#">chiudi</a><h5>come posso monitorare un parlamentare ?</h5>
				<p>Nella pagina di ogni deputato e senatore in alto a destra trovi il bottone che ti permette di avviare il monitoraggio, contrassegnata dalla icona della lente di ingrandimento. Una volta scelto di seguire un parlamentare riceverai tutte le notizie e informazioni relative - ogni volta che ce ne saranno - sia nelle tue pagine personali del "monitoraggio" ("le mie notizie" - "i tuoi parlamentari") che nella tua casella email attraverso la "newsletter". Per smettere di monitorare l'atto o il parlamentare &egrave; sufficiente andare nella pagina dell'atto o parlamentare dove in alto a destra si trova il bottone "smetti di monitorare". La stessa funzione &egrave; disponibile anche nella pagina "i miei parlamentari" dove per ciascun deputato e senatore elencato &egrave; disponibile il bottone "smetti di monitorare" (icona della crocetta rossa accanto la lente di ingrandimento)</p>
			</div>
		</div>

    <?php if (count($monitored_politicians)): ?>
    	<h5 class="subsection">i parlamentari che stai monitorando</h5>
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
    <?php else: ?>
      	<h5 class="subsection">i parlamentari che stai monitorando</h5>
      <p style="font-size:14px; padding:10px;">Non stai monitorando nessun parlamentare.<br /> Per avviare un monitoraggio vai nella pagina di un parlamentare (<?php echo link_to('deputati','/parlamentari/camera/nome/asc') ?> e <?php echo link_to('senatori','/parlamentari/senato/nome/asc') ?>) e clicca su "avvia il monitoraggio" che trovi nella parte destra della pagina.</p>     
    <?php endif ?>
    <a name="rappresentometro">&nbsp;</a>  
    
  <!--  Mostra dieci parlamentari per gli utenti normali, TUTTI per gli ad hoc -->  
  <?php echo include_component('monitoring', 'userVspolitician', 
                               array('user'        => $sf_user, 
                                     'num'         => $sf_user->hasCredential('adhoc')?1000:10, 
                                     'ambient'     => 'monitor', 
                                     'legislatura' => 16)); ?>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  i miei parlamentari
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
