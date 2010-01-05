<?php echo use_helper('PagerNavigation'); ?>

<h5 class="subsection"><?php echo $pager->getNbResults() ?> interventi</h5>

<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">data:</th>
      <th scope="col">sede:</th>
      <th scope="col">atto:</th>  
      <th scope="col">testo dell'intervento:</th>
    </tr>
  </thead>

  <tbody>
  <?php $tr_class = 'even' ?>			
    <?php foreach ($pager->getResults() as $intervento): ?>
      <?php $atto = $intervento->getOppAtto(); ?>
       <tr class="<?php echo $tr_class; ?>">
       <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo ($intervento->getData() ? $intervento->getData('d-m-Y') : '') ?></span>
          </p>
        </th>
        <td>
          <p>
            <?php echo $intervento->getOppSede()->getDenominazione() ?>
          </p>
        </td>
        <th scope="row">
         <p class="content-meta">
         <?php echo $atto->getOppTipoAtto()->getDescrizione().($atto->getRamo()=='C' ? ' alla Camera' : ' al Senato') ?>
         </p>
          <p>
            <?php echo link_to(Text::denominazioneAtto($atto, 'list'), 'atto/index?id='.$atto->getId()) ?>
          </p>
        </th>
        <td>
          <p> <?php echo link_to('Vai al sito ' . 
                                 ($intervento->getOppSede()->getRamo() == 'C'?'della Camera':'del Senato') , $intervento->getUrl()) ?> </p>
        </td>	
      </tr>
    <?php endforeach; ?>
    <tr>
      <td align="center" colspan='4'>
        <?php echo pager_navigation($pager, '@parlamentare_interventi?id='.$parlamentare_id) ?>
      </td>
    </tr>

    <tr>
      <td align="center" colspan='4'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </td>
    </tr>
  </tbody>
</table>