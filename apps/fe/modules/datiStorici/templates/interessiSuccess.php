<?php echo use_helper('Javascript') ?>

<?php include_partial('tabs', array('current' => 'interessi')) ?>

<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">

      <?php echo include_partial('datiStorici/searchWithAutocompleter', 
                                 array('argomento' => $argomento,
                                       'ramo' => $ramo,
                                       'tag_count'=>TagPeer::getAllWithCount())); ?>


      <?php if ($argomento): ?>
        <div class="evidence-box float-container">

          <h5 class="subsection">
            <?php if ($ramo == 'C'): ?>
              Deputati
            <?php else: ?>
              Senatori
            <?php endif ?>
            che si occupano di <em><?php echo $argomento->getTripleValue() ?></em>
          </h5>

          <div class="pad10">

            <?php if (isset($politici) && count($politici) > 0): ?>
            	<ul>
            	  <?php $cnt = 0; foreach ($politici as $carica_id => $politico): ?>
           	      <li style="font-size:12px; padding:5px 0 0 0;">
           	        <?php echo ++$cnt ?>)
           	        <?php echo link_to($politico['nome'] . " " . $politico['cognome'] . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'], array('class' => 'folk2', 'title' => $politico['punteggio'])); ?> (<?php echo $politico['punteggio'] ?>)
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

