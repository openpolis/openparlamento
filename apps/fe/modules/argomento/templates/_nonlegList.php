<?php echo use_helper('PagerNavigation'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col">tipologia:</th>      
      <th scope="col">atto:</th>
      <th scope="col">ultimo<br />aggiornamento:</th>
      <th scope="col">interventi in<br />Parlamento:</th>
      <th scope="col">voti e commenti<br />degli utenti:</th>
    </tr>
  </thead>

  <tbody>		  
    <?php foreach ($pager->getResults() as $ddl): ?>
      <tr>
        <td width="10%"><p><?php echo $ddl->getOppTipoAtto()->getDenominazione() ?></p></td>
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo format_date($ddl->getDataPres(), 'dd/MM/yyyy') ?>,</span>
            <span><?php echo $ddl->getOppTipoAtto()->getDescrizione() ?><?php echo($ddl->getRamo()=='C' ? ' alla Camera' : ' al Senato') ?>
            <?php $f_signers= OppAttoPeer::doSelectPrimiFirmatari($ddl->getId()); ?>
            <?php if (count($f_signers)>0) : ?>
               <?php $c = new Criteria() ?>
               <?php $c->add(OppPoliticoPeer::ID, key($f_signers), Criteria::EQUAL); ?>
               <?php $f_signer = OppPoliticoPeer::doSelectOne($c) ?>
               <?php echo ' di '.$f_signer->getCognome().(count($f_signers)>1 ? ' e altri' : '') ?>
             <?php endif; ?>   
            </span> 
          </p>
	      <p>
            <?php echo link_to(Text::denominazioneAtto($ddl, 'list'), 'atto/index?id='.$ddl->getId()) ?>
          </p>
        </th>  	
        <td>
          <?php if($ddl->getStatoFase()!=''): ?>
            <p class="date"><?php echo format_date($ddl->getStatoLastDate() , 'dd/MM/yyyy') ?></p>
            <p class="gold"><?php echo $ddl->getStatoFase() ?></p>
          <?php else: ?>
            <p class="date"><?php echo format_date($ddl->getDataPres() , 'dd/MM/yyyy') ?></p>
            <p class="gold">PRESENTATO</p>
          <?php endif; ?>  
        </td>
        <td><?php echo $ddl->getNInterventi() ?></td>
        <td>
          <div class="user-stats-column">
            <span class="green thumb-up"><?php echo $ddl->getUtFav() ?></span><span class="red thumb-down"><?php echo $ddl->getUtContr() ?></span>
            <p><?php echo link_to($ddl->getNbCommenti().' <strong>commenti</strong>', '#') ?></p>
          </div>
        </td>	
      </tr>
    <?php endforeach; ?>
    <tr>
      <td align="center" colspan='5'>
        <?php echo pager_navigation($pager, '@argomento_nonleg?triple_value='.$triple_value) ?>
      </td>
    </tr>
    <tr>
      <td align="center" colspan='5'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	  </td>
    </tr>
  </tbody>		  
</table>