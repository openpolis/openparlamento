<?php echo use_helper('Javascript'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'tags')); ?>

<div id="content" class="tabbed-orange float-container">
  <?php echo include_partial('secondLevelMenuArgomenti', 
                             array('current' => 'deputati')); ?>

  <div id="main">

    <?php if ($sf_flash->has('subscription_promotion')): ?>
      <div class="flash-messages">
        <?php echo $sf_flash->get('subscription_promotion') ?>
      </div>
    <?php endif; ?>
    <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>    
      <div style="width:40%; font-size:14px; line-height:1.2em; border:1px solid #EE7F00; padding:5px;" ><strong>Promuovi la trasparenza e la partecipazione!</strong><br /><?php echo link_to('Prenota la tua tessera 2010 all\'associazione openpolis','@tesseramento') ?>
      </div>
    <?php endif; ?>

    <?php include_partial('monitoring/tagsMonitoredByUser', 
                          array('opp_user' => $opp_user, 'sf_user' => $sf_user, 
                                'my_tags' => $my_tags, 'remaining_tags' => $remaining_tags)) ?>


    <div class="evidence-box float-container">

      <h5 class="subsection">
        I <?php echo sfconfig::get('app_limit_classifica_parlamentari_sioccupanodi', 15)  ?> deputati
        che pi&ugrave; si occupano di questi argomenti 
      </h5>

      <div class="pad10">

        <?php if (isset($politici) && count($politici) > 0): ?>
        	<ul>
      	  <?php $cnt = 0; foreach ($politici as $carica_id => $politico): ?>
     	      <li style="font-size:12px; padding:5px 0 0 0;" id="carica-<?php echo $carica_id ?>">
     	        <?php echo ++$cnt ?>)
     	        <?php echo link_to($politico['nome'] . " " . $politico['cognome'] . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'], array('class' => 'folk2', 'title' => $politico['punteggio'])); ?> (<?php echo $politico['punteggio'] ?>)
     	        (<?php echo link_to('mostra dettaglio',
     	                            '@dati_storici_dettaglio_interessi?carica_id='.$carica_id.'&tags_ids='.implode(",", $tags_ids),
     	                            array('class' => 'show-hide-dettaglio')) ?>)
     	      </li>
      	  <?php endforeach ?>
          </ul>

        <?php else: ?>
          Nessun politico trovato        
        <?php endif ?>
      </div> 
      
      <p id="chart_container" style="background-color:#fff;">
        <img src="http://chart.apis.google.com/chart?<?php echo implode('&amp;', $chart_params) ?>" alt="<?php echo $chart_title ?>" />
      </p>

    </div>

  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('i miei argomenti', 
                     '@monitoring_tags?user_token='. sfContext::getInstance()->getUser()->getToken()) ?> /
  le classifiche dei deputati
<?php end_slot() ?>


<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $().ready(function(){

    $('li a.show-hide-dettaglio').click(
    	function(){
    	  $this = $(this);

    		var parent_li = $this.parents('li');
        var url = $this.attr('href');
        if (!$this.data('details_loaded'))
        {
          parent_li.append("<div style=\"margin-left: 1.5em;\"></div>");
          parent_li.children("div").load(url);
          $this.text('nascondi dettaglio');
          $this.data('details_loaded', true);
        } else {
          parent_li.children("div").remove();
          $this.data('details_loaded', false);
          $this.text('mostra dettaglio');
        }
        return false;
    	}
    );

  	// Setup the ajax indicator
  	$("body").append('<div id="ajaxBusy"><p><img src="/images/loading.gif"></p></div>');

  	$('#ajaxBusy').css({
  		display:"none",
  		padding:"0px",
  		position:"absolute",
  		right:"0px",
  		top:"0px",
  		left:"0px",
  		bottom:"0px",
  		margin:"auto",
  		width:"40px",
  		height:"40px"
  	});

  	// Ajax activity indicator bound 
  	// to ajax start/stop document events
  	$(document).ajaxStart(function(){ 
  		$('#ajaxBusy').show(); 
  	}).ajaxStop(function(){ 
  		$('#ajaxBusy').hide();
  	});


  })
})(jQuery);

//]]>
</script>
