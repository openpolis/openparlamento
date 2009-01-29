<?php $current_class = ($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_atti/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null,  'opp_parlamentare_atti/sort') == 'data_pres'): ?>
        <?php echo link_to('data presentazione',
                           '@parlamentare_atti?id=' . $parlamentare_id.
                             '&sort=data_pres&type=' . 
                             ($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_atti/sort') == 'asc' ? 'desc' : 'asc'), 
                           array('class' => 'current '.$current_class)) ?>
	    <?php else: ?>
        <?php echo link_to('data presentazione', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=data_pres&type=asc') ?>
      <?php endif; ?>
	  </li>

	  <li>
      <?php if ($sf_user->getAttribute('sort', null,  'opp_parlamentare_atti/sort') == 'stato_last_date'): ?>
        <?php echo link_to('ultimo aggiornamento', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=stato_last_date&type='.($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_atti/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	    <?php else: ?>
        <?php echo link_to('ultimo aggiornamento', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=stato_last_date&type=asc') ?>
      <?php endif; ?>
	  </li>

	  <li>
      <?php if ($sf_user->getAttribute('sort', null,  'opp_parlamentare_atti/sort') == 'n_interventi'): ?>
        <?php echo link_to('interventi', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=n_interventi&type='.($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_atti/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	    <?php else: ?>
        <?php echo link_to('interventi', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=n_interventi&type=asc') ?>
      <?php endif; ?>
	  </li>

	  <li>
      <?php if ($sf_user->getAttribute('sort', null,  'opp_parlamentare_atti/sort') == 'ut_fav'): ?>
        <?php echo link_to('utenti favorevoli', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=ut_fav&type='.($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_atti/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	    <?php else: ?>
        <?php echo link_to('utenti favorevoli', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=ut_fav&type=asc') ?>
      <?php endif; ?>
	  </li>
	  
    <li>
      <?php if ($sf_user->getAttribute('sort', null,  'opp_parlamentare_atti/sort') == 'ut_contr'): ?>
        <?php echo link_to('utenti contrari', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=ut_contr&type='.($sf_user->getAttribute('type', 'asc',  'opp_parlamentare_atti/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	    <?php else: ?>
        <?php echo link_to('utenti contrari', '@parlamentare_atti?id=' . $parlamentare_id . '&sort=ut_contr&type=asc') ?>
      <?php endif; ?>
	  </li>
  </ul>
</div>