<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'data_pres'): ?>
        <?php echo link_to('data presentazione', '@attiDisegni?sort=data_pres&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('data presentazione', '@attiDisegni?sort=data_pres&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'stato_last_date'): ?>
        <?php echo link_to('ultimo aggiornamento', '@attiDisegni?sort=stato_last_date&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'asc' : 'desc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('ultimo aggiornamento', '@attiDisegni?sort=stato_last_date&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'n_interventi'): ?>
        <?php echo link_to('interventi in Parlamento', '@attiDisegni?sort=n_interventi&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('interventi in Parlamento', '@attiDisegni?sort=n_interventi&type=desc') ?>
      <?php endif; ?>
    </li>
   <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'ut_fav'): ?>
        <?php echo link_to('utenti favorevoli', '@attiDisegni?sort=ut_fav&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('utenti favorevoli', '@attiDisegni?sort=ut_fav&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'ut_contr'): ?>
        <?php echo link_to('utenti contrari', '@attiDisegni?sort=ut_contr&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('utenti contrari', '@attiDisegni?sort=ut_contr&type=desc') ?>
      <?php endif; ?>
    </li>
  </ul>
</div>