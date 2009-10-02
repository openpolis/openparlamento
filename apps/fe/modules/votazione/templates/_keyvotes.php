<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col"><br />sigla/titolo:</th>
      <th scope="col">esito in<br />Parlamento:</th>
      <th scope="col">voti di<br />scarto:</th>
      <th scope="col">numero di<br />ribelli:</th>
    </tr>
  </thead>

  <tbody>
   <?php $tr_class = 'even' ?>
    <?php foreach ($votazioni as $votazione): ?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?> - <?php echo ($votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ) ?>, seduta n. <?php echo ($votazione->getOppSeduta()->getNumero() ) ?></span>
          </p>
          <p><?php echo link_to(($votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo()), '@votazione?id='.$votazione->getId()) ?></p>
       </th>
        
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
 		  		
</table>