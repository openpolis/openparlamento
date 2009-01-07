<?php $current_class = ($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_carica/sort') == 'asc' ? 'ascending' : 'descending') ?>


<div id="disegni-decreti-order" class="float-container tools-container">
  <p>ordina per</p>
  <ul>
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_carica/sort') == 'nome'): ?>
        <?php echo link_to('nome', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=nome&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_carica/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('nome', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=nome&type=asc') ?>
      <?php endif; ?>
	</li>	
    <li>
      <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_carica/sort') == 'presenze'): ?>
        <?php echo link_to('presenze', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=presenze&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_carica/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('presenze', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=presenze&type=desc') ?>
      <?php endif; ?>
	</li>
    <li>
	  <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_carica/sort') == 'assenze'): ?>
        <?php echo link_to('assenze', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=assenze&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_carica/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
	  <?php else: ?>
        <?php echo link_to('assenze', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=assenze&type=desc') ?>
      <?php endif; ?>
	</li>
	<li>
	  <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_carica/sort') == 'indice'): ?>
        <?php echo link_to('indice di attivit&agrave;', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=indice&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_carica/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('indice di attivit&agrave;', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=indice&type=desc') ?>
      <?php endif; ?>
	</li>
    <li>
	  <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/opp_carica/sort') == 'ribelle'): ?>
        <?php echo link_to('voti ribelli', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=ribelle&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/opp_carica/sort') == 'asc' ? 'desc' : 'asc'), array('class' => 'current '.$current_class)) ?>
      <?php else: ?>
        <?php echo link_to('voti ribelli', '@parlamentari?ramo='.$sf_params->get('ramo', 'camera').'&sort=ribelle&type=desc') ?>
      <?php endif; ?>
	</li>
  </ul>
</div>