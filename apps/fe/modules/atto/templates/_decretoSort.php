<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'data_pres'): ?>
        <?php echo link_to('data di emanazione', 'atto/decretoList?sort=data_pres&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('data di emanazione', '@attiDecretiLegge?sort=data_pres&type=desc') ?>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'stato_fase'): ?>
        <?php echo link_to('stato di avanzamento', '@attiDecretiLegge?sort=stato_fase&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('stato di avanzamento', '@attiDecretiLegge?sort=stato_fase&type=desc') ?>
      <?php endif; ?>
    </li>
    
  </ul>
</div>