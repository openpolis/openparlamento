<?php if ($n_firme_pr): ?>
    <?php use_helper('Slugger'); ?>
  <li id="carica-<?php echo $carica_id ?>" class="dettaglio-carica">
    <h5><?php echo link_to($politico['nome'] . " " . $politico['cognome'] . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'].'&slug='.slugify($politico['nome'] . " " . $politico['cognome']), array('class' => 'folk2', 'title' => $politico['punteggio'])); ?> (<?php echo $politico['punteggio'] ?>)</h5>

    <div class="elenco-atti">
      <?php if (count($politico['firme_p'])): ?>
        <b>Come primo firmatario</b><br/>
        <ul>
          <?php foreach ($politico['firme_p'] as $firma): ?>
            <?php $atto = $firma['atto'] ?>
            <li>
              <?php echo strtolower($atto->getOppTipoAtto()->getDescrizione()) . " - " . link_to($atto->getTitoloCompleto(), '@singolo_atto?id='.$atto->getId()) ?>
            </li>    
          <?php endforeach ?>
        </ul>  
      <?php endif ?>

      <?php if (count($politico['firme_r'])): ?>
        <b>Come relatore</b><br/>
        <ul>
          <?php foreach ($politico['firme_r'] as $firma): ?>
            <?php $atto = $firma['atto'] ?>
            <li>
              <?php echo strtolower($atto->getOppTipoAtto()->getDescrizione()) . " - " . link_to($atto->getTitoloCompleto(), '@singolo_atto?id='.$atto->getId()) ?>
            </li>    
          <?php endforeach ?>
        </ul>  
      <?php endif ?>

    </div>

  </li>  
<?php endif ?>
