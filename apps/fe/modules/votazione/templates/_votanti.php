<table border=1 cellspacing=1 cellpadding=1>
  <tr><th colspan="4">TUTTI I VOTANTI</th></tr>
  <tr>
  	<th>
	  <?php if ($sf_user->getAttribute('sort', null, 'opp_votazione/sort') == 'cognome'): ?>
      <?php echo link_to('parlamentare', 'votazione/index?id='.$sf_params->get('id').'&sort=cognome&type='.($sf_user->getAttribute('type', 'asc', 'opp_votazione/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo $sf_user->getAttribute('type', 'asc', 'opp_votazione/sort') ?>)
      <?php else: ?>
      <?php echo link_to('parlamentare', 'votazione/index?id='.$sf_params->get('id').'&sort=cognome&type=asc') ?>
      <?php endif; ?>	
	</th>
	<th>
	  <?php if ($sf_user->getAttribute('sort', null, 'opp_votazione/sort') == 'gruppo'): ?>
      <?php echo link_to('gruppo', 'votazione/index?id='.$sf_params->get('id').'&sort=gruppo&type='.($sf_user->getAttribute('type', 'asc', 'opp_votazione/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo $sf_user->getAttribute('type', 'asc', 'opp_votazione/sort') ?>)
      <?php else: ?>
      <?php echo link_to('gruppo', 'votazione/index?id='.$sf_params->get('id').'&sort=gruppo&type=asc') ?>
      <?php endif; ?>	
	</th>
	<th>
	  <?php if ($sf_user->getAttribute('sort', null, 'opp_votazione/sort') == 'circoscrizione'): ?>
      <?php echo link_to('circoscrizione', 'votazione/index?id='.$sf_params->get('id').'&sort=circoscrizione&type='.($sf_user->getAttribute('type', 'asc', 'opp_votazione/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo $sf_user->getAttribute('type', 'asc', 'opp_votazione/sort') ?>)
      <?php else: ?>
      <?php echo link_to('circoscrizione', 'votazione/index?id='.$sf_params->get('id').'&sort=circoscrizione&type=asc') ?>
      <?php endif; ?>	
	</th>
	<th>
	  <?php if ($sf_user->getAttribute('sort', null, 'opp_votazione/sort') == 'voto'): ?>
      <?php echo link_to('voto', 'votazione/index?id='.$sf_params->get('id').'&sort=voto&type='.($sf_user->getAttribute('type', 'asc', 'opp_votazione/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo $sf_user->getAttribute('type', 'asc', 'opp_votazione/sort') ?>)
      <?php else: ?>
      <?php echo link_to('voto', 'votazione/index?id='.$sf_params->get('id').'&sort=voto&type=asc') ?>
      <?php endif; ?>	
	</th>
  </tr>
  <?php while($votanti->next()): ?>
  <tr>
  	<td><?php echo link_to($votanti->getString(2).' '.$votanti->getString(3), '@parlamentare?id='.$votanti->getInt(1)) ?></td>
	<td><?php echo $votanti->getString(4) ?></td>
	<td><?php echo $votanti->getString(5) ?></td>
	<td><?php echo $votanti->getString(6) ?></td>
  </tr>
  <?php endwhile; ?>
</table>