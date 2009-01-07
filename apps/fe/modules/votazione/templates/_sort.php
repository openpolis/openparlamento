<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_votazione/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_votazione/sort') == 'data'): ?>
        <?php echo link_to('data voto', '@votazioni?sort=data&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_votazione/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('data voto', '@votazioni?sort=data&type=asc') ?>
      <?php endif; ?>
	</li>
	<li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_votazione/sort') == 'margine'): ?>
        <?php echo link_to('voti di scarto', '@votazioni?sort=margine&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_votazione/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('voti di scarto', '@votazioni?sort=margine&type=asc') ?>
      <?php endif; ?>
	</li>
   <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_votazione/sort') == 'ribelli'): ?>
        <?php echo link_to('numero di ribelli', '@votazioni?sort=ribelli&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_votazione/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('numero di ribelli', '@votazioni?sort=ribelli&type=asc') ?>
      <?php endif; ?>
	</li>
  </ul>
</div>