<?php $current_class = ($sf_user->getAttribute('type', 'asc', $session_namespace) == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, $session_namespace) == 'data_pres'): ?>
        <?php echo link_to('data presentazione', $route.'?triple_value='.$triple_value.'&sort=data_pres&type='.($sf_user->getAttribute('type', 'asc', $session_namespace) == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('data presentazione', $route.'?triple_value='.$triple_value.'&sort=data_pres&type=asc') ?>
      <?php endif; ?>
	</li>
	<li>
      <?php if ($sf_user->getAttribute('sort', null, $session_namespace) == 'stato_last_date'): ?>
        <?php echo link_to('ultimo aggiornamento', $route.'?triple_value='.$triple_value.'&sort=stato_last_date&type='.($sf_user->getAttribute('type', 'asc', $session_namespace) == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('ultimo aggiornamento', $route.'?triple_value='.$triple_value.'&sort=stato_last_date&type=asc') ?>
      <?php endif; ?>
	</li>
      <?php if ($sf_user->getAttribute('sort', null, $session_namespace) == 'n_interventi'): ?>
        <?php echo link_to('interventi in Parlamento', $route.'?triple_value='.$triple_value.'&sort=n_interventi&type='.($sf_user->getAttribute('type', 'asc', $session_namespace) == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('interventi in parlamento', $route.'?triple_value='.$triple_value.'&sort=n_interventi&type=asc') ?>
      <?php endif; ?>
	<li>
      <?php if ($sf_user->getAttribute('sort', null, $session_namespace) == 'ut_fav'): ?>
        <?php echo link_to('utenti favorevoli', $route.'?triple_value='.$triple_value.'&sort=ut_fav&type='.($sf_user->getAttribute('type', 'asc', $session_namespace) == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('utenti favorevoli', $route.'?triple_value='.$triple_value.'&sort=ut_fav&type=asc') ?>
      <?php endif; ?>
	</li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, $session_namespace) == 'ut_contr'): ?>
        <?php echo link_to('utenti contrari', $route.'?triple_value='.$triple_value.'&sort=ut_contr&type='.($sf_user->getAttribute('type', 'asc', $session_namespace) == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('utenti contrari', $route.'?triple_value='.$triple_value.'&sort=ut_contr&type=asc') ?>
      <?php endif; ?>
	</li>
  </ul>
</div>