<?php use_helper('Date', 'I18N', 'Parlamentare') ?>

<table border=1 cellspacing=1 cellpadding=1>
  <tr>
    <th colspan="12">TUTTI I VOTI</th>	
  </tr>
  <tr>
    <th>ramo</th>
	<th>legislatura</th>
	<th>data</th> 	
    <th>titolo</th>
	<th>voto del parlamentare</th>
	<th>voto del gruppo</th>
	<th>esito della votazione</th>
  </tr>
  <?php foreach($pager->getResults() as $id => $voto): ?>
  <tr>
  	<td class="<?php ribelleStyle($voto['voto'], $voto['voto_gruppo']) ?>"><?php echo $voto['ramo'] ?></td>
	<td class="<?php ribelleStyle($voto['voto'], $voto['voto_gruppo']) ?>"><?php echo $voto['legislatura'] ?></td>
	<td class="<?php ribelleStyle($voto['voto'], $voto['voto_gruppo']) ?>"><?php echo format_date($voto['data'], 'dd/MM/yyyy') ?></td>
	<td class="<?php ribelleStyle($voto['voto'], $voto['voto_gruppo']) ?>"><?php echo link_to($voto['titolo'], 'votazione/index?id='.$id ) ?></td>
	<td class="<?php ribelleStyle($voto['voto'], $voto['voto_gruppo']) ?>"><?php echo $voto['voto'] ?></td>
	<td class="<?php ribelleStyle($voto['voto'], $voto['voto_gruppo']) ?>"><?php echo $voto['voto_gruppo'] ?></td>
	<td class="<?php ribelleStyle($voto['voto'], $voto['voto_gruppo']) ?>"><?php echo $voto['esito'] ?></td>
  </tr>
  <?php endforeach; ?>
  <tr>
    <td colspan="12" align="center">
      <?php if ($pager->haveToPaginate()): ?>
        <?php echo link_to('<<', 'parlamentare/index?id='.$sf_params->get('id').'&page=1') ?>
        <?php echo link_to('<', 'parlamentare/index?id='.$sf_params->get('id').'&page='.$pager->getPreviousPage()) ?>
        <?php foreach ($pager->getLinks() as $page): ?>
          <?php echo link_to_unless($page == $pager->getPage(), $page, 'parlamentare/index?id='.$sf_params->get('id').'&page='.$page) ?>
        <?php endforeach; ?>
        <?php echo link_to('>', 'parlamentare/index?id='.$sf_params->get('id').'&page='.$pager->getNextPage()) ?>
          <?php echo link_to('>>', 'parlamentare/index?id='.$sf_params->get('id').'&page='.$pager->getLastPage()) ?>
        <?php endif; ?>    	
    </td>	
  </tr>
  <tr>
    <td colspan="12" align="center">
      <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	</td>
  </tr>		
</table>  	