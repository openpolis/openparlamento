<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'chi_id'): ?>
        <?php echo link_to('id parlamentare', 'datiStorici/indice?sort=chi_id&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('id parlamentare', 'datiStorici/indice?sort=chi_id&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'presenze'): ?>
        <?php echo link_to('presenze', 'datiStorici/presenze?sort=presenze&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('presenze', 'datiStorici/presenze?sort=presenze&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'assenze'): ?>
        <?php echo link_to('assenze', 'datiStorici/assenze?sort=assenze&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('assenze', 'datiStorici/assenze?sort=assenze&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'missioni'): ?>
        <?php echo link_to('missioni', 'datiStorici/missioni?sort=missioni&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('missioni', 'datiStorici/missioni?sort=missioni&type=desc') ?>
      <?php endif; ?>
    </li>
  </ul>
</div>