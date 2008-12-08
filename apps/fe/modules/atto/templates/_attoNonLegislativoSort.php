<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'ascending' : 'descending') ?>

<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_atto/sort') == 'data_pres'): ?>
        <?php echo link_to('data presentazione', '@attiNonLegislativi?sort=data_pres&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_atto/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('data presentazione', '@attiNonLegislativi?sort=data_pres&type=asc') ?>
      <?php endif; ?>
	</li>		
    <li><a href="#">ultimo aggiornamento</a></li>
    <li><a href="#">interventi</a></li>			
    <li><a href="#">utenti favorevoli</a></li>
    <li><a href="#">utenti contrari</a></li>
    <li><a href="#">commenti</a></li>	
  </ul>
</div>