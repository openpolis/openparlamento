<div class="evidence-box float-container" style="float: left; width: 90%">

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
              <th scope="col">Circoscrizione:</th>
              <th scope="col">Commissone Perm.:</th>              
              <th scope="col">Impact:</th>
              <th scope="col">Posizione:</th>
            </tr>
          </thead>

          <tbody>

        	  <?php $tr_class = 'even'; $cnt = 0; 
        	  use_helper('Slugger');
        	  foreach ($politici as $carica_id => $politico): ?>
       	        
                <tr class="<?php echo $tr_class; ?>" id="carica-<?php echo $carica_id ?>">
                <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
                  <td><?php echo ++$cnt ?></td>
                  <th scope="row">  
                    <p class="politician-id">
                      <?php echo image_tag(OppPoliticoPeer::getThumbUrl($politico['politico_id']), 
                                           array('width' => '40','height' => '53')) ?>
                      <?php 
                      $fullName = $politico['nome'] . " " . $politico['cognome'];
                      echo link_to($fullName . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'] .'&slug='.slugify($fullName), array('class' => 'folk2')); ?>
                    </p>
                  </th>
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
                    <?php if ($sf_user->hasCredential('amministratore')): ?>
                        (<?php echo link_to('dettaglio',
                                            '@dati_storici_dettaglio_interessi?carica_id='.$carica_id.'&tags_ids='.implode(",", $tags_ids),
                                             array('class' => 'link-dettaglio-interessi')) ?>)
                    <?php endif ?>                    
                  </td>
                  <td style="text-align: right; padding-right: 20px">
                    <?php printf("%7.2f",   OppCaricaPeer::getPosizionePoliticoOggettiVotatiPerArgomenti($carica_id, $tags_ids, $sf_user->getId())) ?>
                    <?php if ($sf_user->hasCredential('amministratore')): ?>
                        (<?php echo link_to('dettaglio',
                                            '@monitoring_dettaglio_posizione?carica_id='.$carica_id.'&tags_ids='.implode(",", $tags_ids),
                                             array('class' => 'link-dettaglio-posizione')) ?>)
                    <?php endif ?>                    
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

    $('a.link-dettaglio-interessi').click(
    	function(){
    	  $this = $(this);

    		var parent_tr = $this.parents('tr');
        var url = $this.attr('href');
        if (!$this.data('details_loaded'))
        {
          parent_tr.after("<tr id=\"dettaglio-interessi\" style=\"margin-left: 1.5em;\"><td colspan=\"6\" style=\"text-align:left; padding-left: 90px;\"></td></tr>");
          $('#dettaglio-interessi td').load(url);
          $this.text('nascondi');
          $this.data('details_loaded', true);
        } else {
          $('#dettaglio-interessi').remove();
          $this.data('details_loaded', false);
          $this.text('dettaglio');
        }
        return false;
    	}
    );

    $('a.link-dettaglio-posizione').click(
    	function(){
    	  $this = $(this);

    		var parent_tr = $this.parents('tr');
        var url = $this.attr('href');
        if (!$this.data('details_loaded'))
        {
          parent_tr.after("<tr id=\"dettaglio-posizione\" style=\"margin-left: 1.5em;\"><td colspan=\"6\" style=\"text-align:left; padding-left: 90px;\"></td></tr>");
          $('#dettaglio-posizione td').load(url);
          $this.text('nascondi');
          $this.data('details_loaded', true);
        } else {
          $('#dettaglio-posizione').remove();
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
  		position:"fixed",
  		left:"50%",
  		top:"50%",
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

