<?php echo use_helper('PagerNavigation'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">disegno di legge:</th>
      <th scope="col">ultimo<br />aggiornamento:</th>  
      <th scope="col">interventi in<br />Parlamento:</th>
      <th scope="col">voti e commenti<br />degli utenti:</th>
    </tr>
  </thead>

  <tbody>		
    <?php foreach ($pager->getResults() as $atto): ?>
      <tr>
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?></span>
            <span>, <?php echo($atto->getRamo()=='C' ? 'presentato alla Camera' : 'presentato al Senato') ?></span>
          </p>
          <p>
            <?php echo link_to('<em>'.$atto->getRamo().'.'.$atto->getNumfase().'</em> '.$atto->getTitolo(), 'atto/index?id='.$atto->getId()) ?>
          </p>
        </th>
        <td>
          <?php $status = $atto->getStatus(); ?>
          <?php foreach($status as $data => $status_iter): ?>
            <p class="date"><?php echo format_date($data, 'dd/MM/yyyy') ?></p>
            <?php $c = new Criteria() ?>
            <?php $c->add(OppIterPeer::ID, $status_iter, Criteria::EQUAL); ?>
            <?php $iter = OppIterPeer::doSelectOne($c) ?>
            <p class="gold"><?php echo $iter->getFase() ?></p>
          <?php endforeach; ?>
        </td>
        <td><p><?php echo $atto->getNInterventi() ?></p></td>
        <td>
          <div class="user-stats-column">
            <span class="green thumb-up"><?php echo $atto->getUtFav() ?></span><span class="red thumb-down"><?php echo $atto->getUtContr() ?></span>
            <p><?php echo link_to($atto->getNbCommenti().' <strong>commenti</strong>', '#') ?></p>
          </div>
        </td>	
      </tr>
    <?php endforeach; ?>
    <tr>
      <td align="center" colspan='4'>
        <?php echo pager_navigation($pager, 'atto/disegnoList') ?>
      </td>
    </tr>

    <tr>
      <td align="center" colspan='4'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </td>
    </tr>
  </tbody>
</table>