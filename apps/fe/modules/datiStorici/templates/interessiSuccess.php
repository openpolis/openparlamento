<?php echo use_helper('Javascript') ?>

<div class="row">
	<div class="twelvecol">
		
		<?php include_partial('tabs', array('current' => 'interessi')) ?>
		
	</div>
</div>

<div class="row">
	<div class="twelvecol">
		<a name="top"></a>
		<?php echo include_partial('datiStorici/searchWithAutocompleter', 
	                                 array('limit' => sfconfig::get('app_limit_interessi_argomento', 50),
	                                       'tags' => $tags,
	                                       'ramo' => $ramo,
	                                       'tag_count'=>TagPeer::getAllWithCount())); ?>


	      <?php if (count($tags_ids)): ?>
	        <div class="evidence-box float-container">

	          <h5 class="subsection">
	            I <?php echo sfconfig::get('app_limit_interessi_argomento', 50)  ?>
	            <?php if ($ramo == 'C'): ?>
	              deputati
	            <?php else: ?>
	              senatori
	            <?php endif ?>
	            che pi&ugrave; si occupano di <em><?php echo $tags ?></em>
	          </h5>

	          <div class="pad10">

	            <?php if (isset($politici) && count($politici) > 0): ?>
	            	<ul>
	            	  <?php $cnt = 0; use_helper('Slugger'); foreach ($politici as $carica_id => $politico): ?>
	           	      <li style="font-size:12px; padding:5px 0 0 0;" id="carica-<?php echo $carica_id ?>">
	           	        <?php echo ++$cnt ?>)
	           	        <?php echo link_to($politico['nome'] . " " . $politico['cognome'] . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'] .'&slug='. slugify($politico['nome'] . " " . $politico['cognome'] ), array('class' => 'folk2', 'title' => $politico['punteggio'])); ?> (<?php echo $politico['punteggio'] ?>)
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

	        </div>

	      <?php endif ?>
		
	</div>
</div>

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

