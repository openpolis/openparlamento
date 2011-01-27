<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'indice'): ?>
        <?php echo link_to('indice', 'datiStorici/indicePresenze?sort=indice&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('indice', 'datiStorici/indicePresenze?sort=indice&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'presenze'): ?>
        <?php echo link_to('presenze', 'datiStorici/indicePresenze?sort=presenze&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('presenze', 'datiStorici/indicePresenze?sort=presenze&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'assenze'): ?>
        <?php echo link_to('assenze', 'datiStorici/indicePresenze?sort=assenze&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('assenze', 'datiStorici/indicePresenze?sort=assenze&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'missioni'): ?>
        <?php echo link_to('missioni', 'datiStorici/indicePresenze?sort=missioni&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('missioni', 'datiStorici/indicePresenze?sort=missioni&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'ribellioni'): ?>
        <?php echo link_to('ribellioni', 'datiStorici/indicePresenze?sort=ribellioni&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('ribellioni', 'datiStorici/indicePresenze?sort=ribellioni&type=desc') ?>
      <?php endif; ?>
    </li>
  </ul>
</div>