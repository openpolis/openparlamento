<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'data_pres'): ?>
        <?php echo link_to('data presentazione', 'atto/disegnoList?sort=data_pres&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('data presentazione', 'atto/disegnoList?sort=data_pres&type=asc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'stato_last_date'): ?>
        <?php echo link_to('ultimo aggiornamento', 'atto/disegnoList?sort=stato_last_date&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('ultimo aggiornamento', 'atto/disegnoList?sort=stato_last_date&type=asc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'n_interventi'): ?>
        <?php echo link_to('interventi in Parlamento', 'atto/disegnoList?sort=n_interventi&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('interventi in Parlamento', 'atto/disegnoList?sort=n_interventi&type=asc') ?>
      <?php endif; ?>
    </li>
   <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'ut_fav'): ?>
        <?php echo link_to('utenti favorevoli', 'atto/disegnoList?sort=ut_fav&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('utenti favorevoli', 'atto/disegnoList?sort=ut_fav&type=asc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'ut_contr'): ?>
        <?php echo link_to('utenti contrari', 'atto/disegnoList?sort=ut_contr&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('utenti contrari', 'atto/disegnoList?sort=ut_contr&type=asc') ?>
      <?php endif; ?>
    </li>
  </ul>
</div>