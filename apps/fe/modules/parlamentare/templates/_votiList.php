<?php echo use_helper('PagerNavigation'); ?>

<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col"><br />sigla/titolo:</th>
      <th scope="col"><br />data voto:</th>
      <th scope="col">voto del<br />parlamentare:</th>
      <th scope="col">voto del<br />gruppo:</th>
      <th scope="col">esito in<br />Parlamento:</th>
      <th scope="col">voti di<br />scarto:</th>
      <th scope="col">numero di<br />ribelli:</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($pager->getResults() as $votazione): ?>
      <tr>
        <th scope="row"><p><?php echo link_to($votazione->getTitolo(), '@votazione?id='.$votazione->getId()) ?></p></td>
        <td><p><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></p></td>
        <td><p>TODO</p></td>
        <td><p>TODO</p></td>
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
           'parlamentare_voti/id='.$parlamentare_id) ?>
      </td>	
    </tr>
    <tr>
      <td colspan="6" align="center">
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	  </td>
    </tr>
  </tfoot>  		  		
</table>