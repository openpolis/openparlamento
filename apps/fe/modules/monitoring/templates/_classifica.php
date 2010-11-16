<div class="evidence-box float-container" style="float: left; width: 50%">

  <h5 class="subsection">
    I <?php echo sfconfig::get('app_limit_classifica_parlamentari_sioccupanodi', 15)  ?> deputati
    che pi&ugrave; si occupano di questi argomenti 
  </h5>

  <div class="pad10"">

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
  
</div>

<p id="chart_container" style="background-color:#fff; float: right">
  <img src="http://chart.apis.google.com/chart?<?php echo implode('&amp;', $chart_params) ?>" alt="<?php echo $chart_title ?>" />
</p>
