<?php echo use_helper('PagerNavigation'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">disegno di legge:</th>
      <th scope="col">ultimo<br />aggiornamento:</th>  
      <!--<th scope="col">interventi in<br />Parlamento:</th>-->
      <!--<th scope="col">voti e commenti<br />degli utenti:</th>-->
    </tr>
  </thead>

  <tbody>		
   <?php $tr_class = 'even' ?>	
    <?php foreach ($pager->getResults() as $atto): ?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?>,</span>
            <span><?php echo($atto->getRamo()=='C' ? 'presentato alla Camera' : 'presentato al Senato') ?>
              
              <?php $f_signers= OppAttoPeer::getRecordsetFirmatari($atto->getId(),'P'); ?>
                  <?php if ($f_signers->next()) :?>  
                    <?php echo ' da '.$f_signers->getString(2).' '.$f_signers->getString(3).($f_signers->getString(6)!='' ? ' ('.$f_signers->getString(6).')' :'').($f_signers->next() ? ' e altri' : '') ?>
                  <?php endif; ?>
            </span>
          </p>
          <p>
            <?php echo link_to('<em>'.$atto->getRamo().'.'.(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase()). '</em> '.$atto->getTitolo(), '@singolo_atto?id='.$atto->getId()) ?>
          </p>
        </th>
        <td>
          <?php $status = $atto->getStatus(); ?>
          <?php foreach($status as $data => $status_iter): ?>
            <p class="date"><?php echo format_date($data, 'dd/MM/yyyy') ?></p>
            <?php $c = new Criteria() ?>
            <?php $c->add(OppIterPeer::ID, $status_iter, Criteria::EQUAL); ?>
            <?php $iter = OppIterPeer::doSelectOne($c) ?>
            <p class="<?php echo $iter->getColor() ?>"><?php echo $iter->getFase() ?></p>
          <?php endforeach; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td align="center" colspan='4'>
        <?php echo pager_navigation($pager, '@attiDisegni') ?>
      </td>
    </tr>

    <tr>
      <td align="center" colspan='4'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </td>
    </tr>
  </tbody>
</table>