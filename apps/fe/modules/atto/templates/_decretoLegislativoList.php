<?php echo use_helper('PagerNavigation'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">decreto legislativo:</th>
      <th scope="col">DDL<br />collegato:</th>
      <th scope="col">voti e commenti<br />degli utenti:</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($pager->getResults() as $ddl): ?>
      <tr>
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo format_date($ddl->getDataPres(), 'dd/MM/yyyy') ?></span>
			<span><?php echo substr($ddl->getOppTipoAtto()->getDenominazione(),6) ?></span>
          </p>
          <p>     
            <span><?php echo link_to('DLGS.'.$ddl->getNumfase().' '.$ddl->getTitolo(), 'atto/index?id='.$ddl->getId()) ?></span>
          </p>  
        </th>  	
        <td>da fare</td>
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
      <td align="center" colspan='3'>
        <?php echo pager_navigation($pager, 'atto/decretoLegislativoList') ?>
      </td>
    </tr>
    <tr>
      <td align="center" colspan='4'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </td>
    </tr>
  </tfoot>		  
</table>	 	  