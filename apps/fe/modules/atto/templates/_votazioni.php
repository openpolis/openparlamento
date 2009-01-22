<h5 class="subsection">i voti relativi al disegno di legge:</h5>
<h5 class="subsection-spec">l'ultimo voto:</h5>

<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col"><br />sigla/titolo:</th>
      <th scope="col"><br />data voto:</th>
      <th scope="col">esito in Parlamento:</th>
      <th scope="col">voti di scarto:</th>
      <th scope="col">numero di ribelli:</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($votazioni as $votazione): ?>
	  <?php if($limit_count < $limit): ?>
	    <tr>
          <th scope="row"><p><?php echo link_to($votazione->getTitolo(), '@votazione?id='.$votazione->getId()) ?></p></th>
          <td><p><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></p></td>				
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
		<?php $limit_count++; ?>
	  <?php else: ?>
         <?php break; ?>  	  
	  <?php endif; ?>	
	<?php endforeach; ?>
</tbody>
</table>

<?php if($votazioni_count > $limit): ?>
  <p class="indent">guarda tutti gli altri <strong><?php echo ($votazioni_count - $limit) ?> </strong>voti relativi al disegno di legge... 
    [ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]
  </p>
  <div class="more-results float-container" style="display: none;">
    <table class="disegni-decreti column-table">
      <thead style="visibility: hidden;">
        <tr>
          <th scope="col"><br />sigla/titolo:</th>
          <th scope="col"><br />data voto:</th>
          <th scope="col">esito in Parlamento:</th>
          <th scope="col">voti di scarto:</th>
          <th scope="col">numero di ribelli:</th>
        </tr>
      </thead>
      <tbody>
        <?php $limit_count = 0; ?>      	
        <?php foreach($votazioni as $votazione): ?>
          <?php if ($limit_count >= $limit): ?>
		    <tr>
              <th scope="row"><p><?php echo link_to($votazione->getTitolo(), '@votazione?id='.$votazione->getId()) ?></p></th>
              <td><p><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></p></td>				
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
          <?php else: ?>
            <?php $limit_count++; ?> 			
          <?php endif; ?>			
	    <?php endforeach; ?>
      </tbody>
    </table>
    <div class="more-results-close">[ <?php echo link_to('chiudi', '#', array('class'=>'btn-close action') ) ?> ]</div>
  </div>
<?php endif; ?>  