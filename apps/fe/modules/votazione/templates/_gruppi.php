<table class="disegni-decreti column-table">
  <thead>
    <tr>
  	<th scope="col">Gruppo</th>
	<th scope="col">Favorevoli (<?php echo ($votazione->getFavorevoli()>$votazione->getContrari() ? 'Maggioranza' : 'Minoranza') ?>)</th>
	<th scope="col">Contrari (<?php echo ($votazione->getContrari()>$votazione->getFavorevoli() ? 'Maggioranza' : 'Minoranza') ?>)</th>
	<th scope="col">Astenuti</th>
	<th scope="col">Assenti</th>
    </tr>
  </thead>
  
<?php $totale_assenti = 0 ?>  	
  <tbody>
  <?php foreach ($risultati as $gruppo => $risultato): ?>
  <tr>
  	<?php $direttiva_gruppo = max($risultato['Favorevole'], $risultato['Contrario'], $risultato['Astenuto']) ?>
    <th scope="row"><?php echo $gruppo ?></th>
	<td <?php echo ( ($gruppo!='Gruppo Misto' && $risultato['Favorevole']<$direttiva_gruppo && $risultato['Favorevole']!=0 ) ? 'class="evident"' :'') ?>"><?php echo $risultato['Favorevole'] ?></td>
	<td <?php echo ( ($gruppo!='Gruppo Misto' && $risultato['Contrario']<$direttiva_gruppo && $risultato['Contrario']!=0 ) ? 'class="evident"' :'') ?>"><?php echo $risultato['Contrario'] ?></td>
	<td <?php echo ( ($gruppo!='Gruppo Misto' && $risultato['Astenuto']<$direttiva_gruppo && $risultato['Astenuto']!=0 ) ? 'class="evident"' :'') ?>"><?php echo $risultato['Astenuto'] ?></td>
	<td><?php echo $risultato['Assente'] ?></td>
	<?php $totale_assenti += $risultato['Assente'] ?>
<?php endforeach; ?>
    
    <tr>
  	<th scope="row" style="font-weight:bold;">Totali</th>
  	<td style="font-weight:bold;"><?php echo $votazione->getFavorevoli() ?></td>
	<td style="font-weight:bold;"><?php echo $votazione->getContrari() ?></td>
	<td style="font-weight:bold;"><?php echo $votazione->getAstenuti() ?></td>
	<td style="font-weight:bold;"><?php echo $totale_assenti ?></td>
   </tr>
   
 </tbody>   
</table>