<?php echo use_helper('PagerNavigation', 'I18N'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">parlamentare:</th>
      <th scope="col">indice:</th>  
      <th scope="col">azioni:</th>
    </tr>
  </thead>

  <tbody>		
   <?php $tr_class = 'even' ?>	
    <?php foreach ($pager->getResults() as $record): ?>

      <?php $parlamentare = OppCaricaPeer::retrieveByPK($record->getChiId()) ?>
      
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th scope="row">
          <?php if (!is_null($parlamentare)): ?>
            <p><?php echo link_to($parlamentare->getOppPolitico() . 
                                  " (" . $parlamentare->getGruppo($date)->getAcronimo() . ") ", 
                                  'http://' . sfConfig::get('sf_site_url', 'op_openparlamento') . 
                                  "/parlamentare/" . $parlamentare->getPoliticoId(),
                                  true) ?></p>            
          <?php else:?>
            <p><?php echo link_to($record->getChiId(), 
                                  'http://' . sfConfig::get('sf_site_url', 'op_openparlamento') . 
                                  "/parlamentare/" . $record->getChiId(),
                                  true) ?></p>
          <?php endif ?>
        </th>
        <td class="numeric-value"><p><?php printf("%7.2f", $record->getIndice()) ?></p></td>
        <td>
          <?php if ($parlamentare): ?>
            <p><a href="/xml/indici/politici/<?php echo $parlamentare->getId() ?>.xml" target="_blank">
              vai al dettaglio (XML)
            </a></p>            
          <?php endif ?>
        </td>	
      </tr>
    <?php endforeach; ?>

    <tr>
      <td align="center" colspan='4'>
        <?php echo pager_navigation($pager, 'datiStorici/indice') ?>
      </td>
    </tr>

    <tr>
      <td align="center" colspan='4'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </td>
    </tr>
  </tbody>
</table>