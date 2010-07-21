<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_storici/sort') == 'indice'): ?>
        <?php echo link_to('indice', 'datiStorici/rilevanzaTag?sort=indice&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_storici/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('indice', 'datiStorici/rilevanzaTag?sort=indice&type=desc') ?>
      <?php endif; ?>
    </li>
  </ul>
</div>