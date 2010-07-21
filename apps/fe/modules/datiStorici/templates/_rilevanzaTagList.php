<?php echo use_helper('PagerNavigation', 'I18N'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">argomento:</th>
      <th scope="col">indice:</th>  
      <th scope="col">azioni:</th>
    </tr>
  </thead>

  <tbody>		
   <?php $tr_class = 'even' ?>	
    <?php foreach ($pager->getResults() as $record): ?>

      <?php $tag = TagPeer::retrieveByPK($record->getChiId()) ?>
      
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th><?php echo $tag->getTripleValue() ?></th>
        <td class="numeric-value"><p><?php printf("%7.2f", $record->getIndice()) ?></p></td>
        <td>
          <?php if ($tag): ?>
            <p><a href="/xml/indici/tag/<?php echo $tag->getId() ?>.xml" target="_blank">
              vai al dettaglio (XML)
            </a></p>            
          <?php endif ?>
        </td>	
      </tr>
    <?php endforeach; ?>

    <tr>
      <td align="center" colspan='4'>
        <?php echo pager_navigation($pager, 'datiStorici/rilevanzaTag') ?>
      </td>
    </tr>

    <tr>
      <td align="center" colspan='4'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </td>
    </tr>
  </tbody>
</table>