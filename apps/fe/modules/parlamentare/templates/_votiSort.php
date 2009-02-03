<?php $current_class = ($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_voti/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null,  'opp_parlamentare_voti/sort') == 'data'): ?>
        <?php echo link_to('data',
                           '@parlamentare_voti?id=' . $parlamentare_id.
                             '&sort=data&type=' . 
                             ($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_voti/sort') == 'asc' ? 'desc' : 'asc'), 
                           array('class' => 'current '.$current_class)) ?>
	    <?php else: ?>
        <?php echo link_to('data', '@parlamentare_voti?id=' . $parlamentare_id . '&sort=data&type=asc') ?>
      <?php endif; ?>
	  </li>

	  <li>
      <?php if ($sf_user->getAttribute('sort', null,  'opp_parlamentare_voti/sort') == 'margine'): ?>
        <?php echo link_to('margine', '@parlamentare_voti?id=' . $parlamentare_id . '&sort=margine&type='.($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_voti/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	    <?php else: ?>
        <?php echo link_to('margine', '@parlamentare_voti?id=' . $parlamentare_id . '&sort=margine&type=asc') ?>
      <?php endif; ?>
	  </li>

	  <li>
      <?php if ($sf_user->getAttribute('sort', null,  'opp_parlamentare_voti/sort') == 'ribelli'): ?>
        <?php echo link_to('numero di ribelli', '@parlamentare_voti?id=' . $parlamentare_id . '&sort=ribelli&type='.($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_voti/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	    <?php else: ?>
        <?php echo link_to('numero di ribelli', '@parlamentare_voti?id=' . $parlamentare_id . '&sort=ribelli&type=asc') ?>
      <?php endif; ?>
	  </li>

  </ul>
</div>