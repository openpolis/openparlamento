<table border=1 cellspacing="1" cellpadding="10">
<tr>
  <th colspan="9">LISTA DELLE VOTAZIONI</th>	
</tr>	
<tr> 
  <th>Ramo</th>
  <th>Data</th>
  <th>Titolo</th>
  <th>Esito</th>
  <th>Maggioranza</th>
  <th>Favorevoli</th>
  <th>Contrari</th>
  <th>Astenuti</th>
  <th>Ribelli</th>
</tr>
<?php foreach ($pager->getResults() as $votazione): ?>
  <tr>
    <td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo ($votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ) ?></td>
	<td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></td>
	<td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo link_to($votazione->getTitolo(), '@votazione?id='.$votazione->getId()) ?></td>
	<td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo $votazione->getEsito() ?></td>
	<td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo $votazione->getMaggioranza() ?></td>
	<td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo $votazione->getFavorevoli() ?></td>
	<td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo $votazione->getContrari() ?></td>
	<td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo $votazione->getAstenuti() ?></td>
    <td class="<?php echo($totale_ribelli>0 ? 'ribelli' : '') ?>"><?php echo $votazione->getRibelli() ?></td>
  </tr>
<?php endforeach; ?>
  <tr>
    <td colspan="10" align="center">
      <?php if ($pager->haveToPaginate()): ?>
        <?php echo link_to('<<', '@votazioni?legislatura='.$sf_user->getAttribute('legislatura').'&ramo='.$sf_user->getAttribute('ramo').'&page=1') ?>
        <?php echo link_to('<', '@votazioni?legislatura='.$sf_user->getAttribute('legislatura').'&ramo='.$sf_user->getAttribute('ramo').'&page='.$pager->getPreviousPage()) ?>
        <?php foreach ($pager->getLinks() as $page): ?>
          <?php echo link_to_unless($page == $pager->getPage(), $page, '@votazioni?legislatura='.$sf_user->getAttribute('legislatura').'&ramo='.$sf_user->getAttribute('ramo').'&page='.$page) ?>
        <?php endforeach; ?>
        <?php echo link_to('>', '@votazioni?legislatura='.$sf_user->getAttribute('legislatura').'&ramo='.$sf_user->getAttribute('ramo').'&page='.$pager->getNextPage()) ?>
          <?php echo link_to('>>', '@votazioni?legislatura='.$sf_user->getAttribute('legislatura').'&ramo='.$sf_user->getAttribute('ramo').'&page='.$pager->getLastPage()) ?>
        <?php endif; ?>    	
    </td>	
  </tr>
  <tr>
    <td colspan="10" align="center">
      <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	</td>
  </tr>		
</table>