<h2>Votazioni riferite all'ATTO</h2>
<table>
<tr>
  <th>Data</th>
  <th>Ramo</th>
  <th>Titolo</th>
  <th>Favorevoli</th>
  <th>Contrari</th>
  <th>Esito</th>
  <th>Ribelli</th>	
</tr>	
<?php foreach($votazioni as $votazione): ?>
  <tr <?php echo ($votazione->getFinale()=='1' ? 'style="font-weight:bold"' : '') ?> >
    <td><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></td>
	<td><?php echo ($votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ) ?></td>
	<td><?php echo link_to($votazione->getTitolo(), '@votazione?id='.$votazione->getId()) ?></td>
	<td><?php echo $votazione->getFavorevoli() ?></td>
	<td><?php echo $votazione->getContrari() ?></td>
	<td><?php echo $votazione->getEsito() ?></td>
	<td><?php echo $votazione->getRibelliCount() ?></td>	
  </tr> 
<?php endforeach; ?>
</table>
<br /><br />