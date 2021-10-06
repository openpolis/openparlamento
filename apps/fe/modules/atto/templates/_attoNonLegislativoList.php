<?php echo use_helper('PagerNavigation'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col">atto:</th>
      <th scope="col">ultimo<br />aggiornamento:</th>
    </tr>
  </thead>

  <tbody>		  
    <?php $tr_class = 'even' ?>
    <?php foreach ($pager->getResults() as $ddl): ?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo format_date($ddl->getDataPres(), 'dd/MM/yyyy') ?>,</span>
            <span><?php echo $ddl->getOppTipoAtto()->getDescrizione() ?><?php echo($ddl->getRamo()=='C' ? ' alla Camera' : ' al Senato') ?>
              <?php $f_signers= OppAttoPeer::getRecordsetFirmatari($ddl->getId(),'P'); ?>
              
                  <?php if ($f_signers->next()) :?>  
                    <?php echo ' da '.$f_signers->getString(2).' '.$f_signers->getString(3).($f_signers->getString(6)!='' ? ' ('.$f_signers->getString(6).')' :'').($f_signers->next() ? ' e altri' : '') ?>
                  <?php endif; ?>
            </span> 
          </p>
	      <p>
            <?php echo link_to(Text::denominazioneAtto($ddl, 'list'), 'atto/index?id='.$ddl->getId()) ?>
          </p>
        </th>  	
        <td>
          <?php //include_component('atto', 'statoAttoNonLegislativo', array('ddl' => $ddl)) ?>
          <?php if($ddl->getStatoFase()!=''): ?>
            <p class="date"><?php echo format_date($ddl->getStatoLastDate() , 'dd/MM/yyyy') ?></p>
            <p class="gold"><?php echo strtolower($ddl->getStatoFase()) ?></p>
          <?php else: ?>
            <p class="date"><?php echo format_date($ddl->getDataPres() , 'dd/MM/yyyy') ?></p>
            <p class="gold">presentato</p>
          <?php endif; ?>  
        </td>
        
      </tr>
    <?php endforeach; ?>
    <tr>
      <td align="center" colspan='4'>
        <?php echo pager_navigation($pager, '@attiNonLegislativi') ?>
      </td>
    </tr>
    <tr>
      <td align="center" colspan='4'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	  </td>
    </tr>
  </tbody>		  
</table>