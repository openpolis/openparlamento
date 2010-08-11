<?php echo use_helper('PagerNavigation', 'I18N', 'Parlamentare'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col"><br />voto:</th>
      <th scope="col">voto del<br />parlamentare:</th>
      <th scope="col">voto del<br />gruppo:</th>
      <th scope="col">esito in<br />Parlamento:</th>
      <th scope="col">voti di<br />scarto:</th>
      <th scope="col">numero di<br />ribelli:</th>
    </tr>
  </thead>

  <tbody>
  
    <?php foreach ($pager->getResults() as $votazione_has_carica): ?>
      <?php $votazione = $votazione_has_carica->getOppVotazione(); ?>
      <?php $voto_parlamentare =  $votazione_has_carica->getVoto() ?>
      <?php $data_voto= $votazione->getOppSeduta()->getData()?>
      
      <?php $gruppo=$votazione_has_carica->getOppCarica()->getGruppo($data_voto) ?>
      <?php $voto_gruppo= $votazione->getVotoGruppo($gruppo->getId()) ?>
      <?php //$voto_gruppo = $votazione->getVotoGruppo($id_gruppo_corrente) ?>
      <tr class="<?php echo ribelleStyle($voto_parlamentare, $voto_gruppo) ?>">
        <th scope="row">
        <p class="content-meta">
        <span class="date"><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></span>
        </p>
        <p><?php echo link_to($votazione->getTitolo(), '@votazione?id='.$votazione->getId()) ?></p>
        </th>
        <td><p><?php echo $voto_parlamentare ?></p></td>
        <td><p><?php echo "<small style='color:gray'>".$gruppo->getAcronimo()."</small><br/>"?><?php echo $voto_gruppo?></p></td>
  	    <td>
    		  <?php if($votazione->getEsito()=='APPROVATA'): ?>
    		    <?php $class = "green thumb-approved"; ?>
    		  <?php elseif($votazione->getEsito()=='RESPINTA'): ?>
    		    <?php $class = "red thumb-rejected"; ?>
    		  <?php else: ?>
    		    <?php $class = ""; ?>
          <?php endif; ?>					
  		    <span class="<?php echo $class ?>"><?php echo $votazione->getEsito() ?></span>
  		  </td>
        <td><p><?php echo $votazione->getMargine() ?></p></td>
        <td><p><?php echo $votazione->getRibelli() ?></p></td>
      </tr>
    <?php endforeach; ?>
  </tbody>

  <tfoot>		  		  
    <tr>
      <td colspan="6" align="center">
        <?php echo pager_navigation($pager, 
           '@parlamentare_voti?id='.$parlamentare_id) ?>
      </td>	
    </tr>
    <tr>
      <td colspan="6" align="center">
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	  </td>
    </tr>
  </tfoot>  		  		
</table>