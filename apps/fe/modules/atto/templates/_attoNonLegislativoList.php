<table id="disegni-decreti" class="column-table">
  <thead>
    <tr>
      <th scope="col">atto:</th>
      <th scope="col">ultimo<br />aggiornamento:</th>
      <th scope="col">interventi in<br />Parlamento:</th>
      <th scope="col">voti e commenti<br />degli utenti:</th>
    </tr>
  </thead>

  <tbody>		  
    <?php foreach ($pager->getResults() as $ddl): ?>
      <tr>
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo format_date($ddl->getDataPres(), 'dd/MM/yyyy') ?></span>
            <span><?php echo $ddl->getOppTipoAtto()->getDenominazione() ?>, <?php echo($ddl->getRamo()=='C' ? 'alla Camera' : 'al Senato') ?></span>
          </p>
	      <p>
            <?php echo link_to(Text::denominazioneAtto($ddl, 'list'), 'atto/index?id='.$ddl->getId()) ?>
          </p>
        </th>  	
        <td>
          <?php //include_component('atto', 'statoAttoNonLegislativo', array('ddl' => $ddl)) ?>
          <?php if($ddl->getStatoFase()!=''): ?>
            <p class="date"><?php echo format_date($ddl->getStatoLastDate() , 'dd/MM/yyyy') ?></p>
            <p class="gold"><?php echo $ddl->getStatoFase() ?></p>
          <?php else: ?>
            <p class="date"><?php echo format_date($ddl->getDataPres() , 'dd/MM/yyyy') ?></p>
            <p class="gold">PRESENTATO</p>
          <?php endif; ?>  
        </td>
        <td><?php echo $ddl->getInterventiCount() ?></td>
        <td>
          <div class="user-stats-column">
            <span class="green thumb-up">10.677</span><span class="red thumb-down">17.903</span>
            <p><?php echo link_to('1.130 <strong>commenti</strong>', '#') ?></p>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>

  <tfoot>		  		  
    <tr>
      <td align="center" colspan='4'>
        <?php if ($pager->haveToPaginate()): ?>
          <?php echo link_to('<<', 'atto/attoNonLegislativoList?page=1') ?>
          <?php echo link_to('<', 'atto/attoNonLegislativoList?page='.$pager->getPreviousPage()) ?>
          <?php foreach ($pager->getLinks() as $page): ?>
            <?php echo link_to_unless($page == $pager->getPage(), $page, 'atto/attoNonLegislativoList?page='.$page) ?>
          <?php endforeach; ?>
          <?php echo link_to('>', 'atto/attoNonLegislativoList?page='.$pager->getNextPage()) ?>
          <?php echo link_to('>>', 'atto/attoNonLegislativoList?page='.$pager->getLastPage()) ?>
        <?php endif; ?>    	
      </td>
    </tr>
    <tr>
      <td align="center" colspan='4'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	  </td>
    </tr>
  </tfoot>  		  
</table>