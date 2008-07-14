<table border=1 cellspacing=1 cellpadding=1>
  <tr>
  	<th>Gruppo</th>
	<th>Favorevoli (<?php echo ($votazione->getFavorevoli()>$votazione->getContrari() ? 'Maggioranza' : 'Minoranza') ?>)</th>
	<th>Contrari (<?php echo ($votazione->getContrari()>$votazione->getFavorevoli() ? 'Maggioranza' : 'Minoranza') ?>)</th>
	<th>Astenuti</th>
	<th>Assenti</th>
  </tr>
<?php $totale_assenti = 0 ?>  	
<?php foreach ($risultati as $gruppo => $risultato): ?>
  <tr>
  	<?php $direttiva_gruppo = max($risultato['Favorevole'], $risultato['Contrario'], $risultato['Astenuto']) ?>
    <td><?php echo $gruppo ?></td>
	<td style="<?php echo ( ($gruppo!='Gruppo Misto' && $risultato['Favorevole']<$direttiva_gruppo && $risultato['Favorevole']!=0 ) ? 'font-weight:bold' :'') ?>"><?php echo $risultato['Favorevole'] ?></td>
	<td style="<?php echo ( ($gruppo!='Gruppo Misto' && $risultato['Contrario']<$direttiva_gruppo && $risultato['Contrario']!=0 ) ? 'font-weight:bold' :'') ?>"><?php echo $risultato['Contrario'] ?></td>
	<td style="<?php echo ( ($gruppo!='Gruppo Misto' && $risultato['Astenuto']<$direttiva_gruppo && $risultato['Astenuto']!=0 ) ? 'font-weight:bold' :'') ?>"><?php echo $risultato['Astenuto'] ?></td>
	<td><?php echo $risultato['Assente'] ?></td>
	<?php $totale_assenti += $risultato['Assente'] ?>
<?php endforeach; ?>
  
  <tr>
  	<td>Totali</td>
  	<td><?php echo $votazione->getFavorevoli() ?></td>
	<td><?php echo $votazione->getContrari() ?></td>
	<td><?php echo $votazione->getAstenuti() ?></td>
	<td><?php echo $totale_assenti ?></td>
  </tr>
</table>