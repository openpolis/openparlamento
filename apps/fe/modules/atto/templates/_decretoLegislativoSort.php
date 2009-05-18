<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'data_pres'): ?>
        <?php echo link_to('data di emanazione', 'atto/decretoLegislativoList?sort=data_pres&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('data di emanazione', 'atto/decretoLegislativoList?sort=data_pres&type=asc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'ut_fav'): ?>
        <?php echo link_to('utenti favorevoli', 'atto/decretoLegislativoList?sort=ut_fav&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('utenti favorevoli', 'atto/decretoLegislativoList?sort=ut_fav&type=asc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'ut_contr'): ?>
        <?php echo link_to('utenti contrari', 'atto/decretoLegislativoList?sort=ut_contr&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('utenti contrari', 'atto/decretoLegislativoList?sort=ut_contr&type=asc') ?>
      <?php endif; ?>
    </li>
  </ul>
</div>