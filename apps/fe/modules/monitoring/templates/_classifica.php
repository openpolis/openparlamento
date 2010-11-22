<div class="evidence-box float-container" style="float: left; width: 50%">

  <h5 class="subsection">
    I <?php echo count($politici) ?> deputati
    che 
    <?php if (count($politici) == sfConfig::get('app_limit_classifica_parlamentari_sioccupanodi', 15)): ?>
      pi&ugrave;       
    <?php endif ?>
    si occupano di questi argomenti 
  </h5>


  <div class="pad10">

    <?php if (isset($politici) && count($politici) > 0): ?>
        <table class="disegni-decreti column-table lazyload">

          <thead>
            <tr>
              <th scope="col">Pos:</th>
              <th scope="col">Parlamentare:</th>
              <th scope="col">Gruppo:</th> 	
              <th scope="col">Circoscrizione:</th>
              <th scope="col">Commissone Perm.:</th>              
              <th scope="col">Punteggio:</th>
              <th></th>
            </tr>
          </thead>

          <tbody>

        	  <?php $tr_class = 'even'; $cnt = 0; foreach ($politici as $carica_id => $politico): ?>
       	        
                <tr class="<?php echo $tr_class; ?>" id="carica-<?php echo $carica_id ?>">
                <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
                  <td><?php echo ++$cnt ?></td>
                  <th scope="row">  
                    <p class="politician-id">
                      <?php echo image_tag(OppPoliticoPeer::getThumbUrl($politico['politico_id']), 
                                           array('width' => '40','height' => '53')) ?>
                      <?php echo link_to($politico['nome'] . " " . $politico['cognome'] . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'], array('class' => 'folk2')); ?>
                    </p>
                  </th>
                  <td>
                    <?php echo $politico['acronimo'] ?>
                  </td>
                  <td>
                    <?php echo $politico['circoscrizione'] ?>
                  </td>
                  <td>
                    <?php foreach ($cariche_interne = OppCaricaInternaPeer::getPermanentiAttuali($carica_id) as $c => $carica_interna): ?>
                      <?php echo $tipo_carica = $carica_interna->getOppTipoCarica()->getNome() != 'Componente' ? $tipo_carica : ''; ?>
                      <?php echo $carica_interna->getOppSede()->getDenominazione(); ?>
                      <?php if ($c < count($cariche_interne)-1): ?>,<?php endif ?>
                    <?php endforeach ?>
                  </td>                  
                  <td style="text-align: right; padding-right: 20px">
                    <?php printf("%01.2f", $politico['punteggio']) ?>
                  </td>
                  <td>
                    <?php echo link_to('dettaglio',
                                        '@dati_storici_dettaglio_interessi?carica_id='.$carica_id.'&tags_ids='.implode(",", $tags_ids),
                                         array('class' => 'show-hide-dettaglio')) ?>
                  </td>
                </tr>        
        	  <?php endforeach ?>

         </tbody>

        </table>

    <?php else: ?>
      Nessun politico trovato        
    <?php endif ?>
  </div> 
  
</div>

<!-- slider jQuery per il dettaglio del punteggio di un parlamentare -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $().ready(function(){

    $('a.show-hide-dettaglio').click(
    	function(){
    	  $this = $(this);

    		var parent_tr = $this.parents('tr');
        var url = $this.attr('href');
        if (!$this.data('details_loaded'))
        {
          parent_tr.after("<tr id=\"dettaglio\" style=\"margin-left: 1.5em;\"><td colspan=\"7\" style=\"text-align:left; padding-left: 90px;\"></td></tr>");
          $('#dettaglio td').load(url);
          $this.text('nascondi');
          $this.data('details_loaded', true);
        } else {
          $('#dettaglio').remove();
          $this.data('details_loaded', false);
          $this.text('dettaglio');
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

