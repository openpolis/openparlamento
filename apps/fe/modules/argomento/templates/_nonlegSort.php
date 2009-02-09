<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'argomento/nonleg_sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'argomento/nonleg_sort') == 'data_pres'): ?>
        <?php echo link_to('data presentazione', '@argomento_nonleg?triple_value='.$triple_value.'&sort=data_pres&type='.($sf_user->getAttribute('type', 'asc', 'argomento/nonleg_sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('data presentazione', '@argomento_nonleg?triple_value='.$triple_value.'&sort=data_pres&type=asc') ?>
      <?php endif; ?>
	</li>
	<li>
      <?php if ($sf_user->getAttribute('sort', null, 'argomento/nonleg_sort') == 'stato_last_date'): ?>
        <?php echo link_to('ultimo aggiornamento', '@argomento_nonleg?triple_value='.$triple_value.'&sort=stato_last_date&type='.($sf_user->getAttribute('type', 'asc', 'argomento/nonleg_sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('ultimo aggiornamento', '@argomento_nonleg?triple_value='.$triple_value.'&sort=stato_last_date&type=asc') ?>
      <?php endif; ?>
	</li>
    <li><a href="#">interventi in Parlamento</a></li>
	<li>
      <?php if ($sf_user->getAttribute('sort', null, 'argomento/nonleg_sort') == 'ut_fav'): ?>
        <?php echo link_to('utenti favorevoli', '@argomento_nonleg?triple_value='.$triple_value.'&sort=ut_fav&type='.($sf_user->getAttribute('type', 'asc', 'argomento/nonleg_sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('utenti favorevoli', '@argomento_nonleg?triple_value='.$triple_value.'&sort=ut_fav&type=asc') ?>
      <?php endif; ?>
	</li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'argomento/nonleg_sort') == 'ut_contr'): ?>
        <?php echo link_to('utenti contrari', '@argomento_nonleg?triple_value='.$triple_value.'&sort=ut_contr&type='.($sf_user->getAttribute('type', 'asc', 'argomento/nonleg_sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('utenti contrari', '@argomento_nonleg?triple_value='.$triple_value.'&sort=ut_contr&type=asc') ?>
      <?php endif; ?>
	</li>
  </ul>
</div>