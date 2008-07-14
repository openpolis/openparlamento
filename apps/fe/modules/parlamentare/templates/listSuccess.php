<?php use_helper('Date') ?>

<h1>legislatura: 
  <?php echo ( $sf_user->getAttribute('legislatura')=='16' ? '16esima' : link_to('16esima', '@parlamentari?legislatura=16&carica='.($sf_user->getAttribute('carica')=='Deputato'?'Deputato':'Senatore')) ) ?>
  <?php echo ( $sf_user->getAttribute('legislatura')=='15' ? '15esima' : link_to('15esima', '@parlamentari?legislatura=15&carica='.($sf_user->getAttribute('carica')=='Deputato'?'Deputato':'Senatore')) ) ?>
</h1>
<br />
<br />
<h1>ramo: 
  <?php echo ( $sf_user->getAttribute('carica')=='Deputato' ? 'Deputati' : link_to('Deputati', '@parlamentari?legislatura='.($sf_user->getAttribute('legislatura')=='16' ? '16' : '15').'&carica=Deputato') ) ?>
  <?php echo ( $sf_user->getAttribute('carica')=='Senatore' ? 'Senatori' : link_to('Senatori', '@parlamentari?legislatura='.($sf_user->getAttribute('legislatura')=='16' ? '16' : '15').'&carica=Senatore') ) ?>
</h1>

<table border=1 cellspacing=1 cellpadding=1>
  <tr><th colspan="6">TUTTI I PARLAMENTARI</th></tr>
  <tr>
  	<th>
	  parlamentare	
	</th>
	<th>
	  circoscrizione
	</th>
	<th>
	  gruppo
	</th>
	<th>
	  ribellioni	
	</th>
	<th>
	  presenze
	</th>
	<th>
	  indice di attivit&agrave;<br />(min 0 - max 10, media <?php //echo $parlamentari[0]->getInt(9) ?>)
	</th>
  </tr>
  <?php while($parlamentari->next()): ?>
  <tr>
  	<td><?php echo link_to($parlamentari->getString(3).' '.$parlamentari->getString(4), '@parlamentare?id='.$parlamentari->getInt(2)) ?></td>
	<td><?php echo $parlamentari->getString(5) ?></td>
	<td>
	  <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($parlamentari->getInt(1)) ?>
	  <?php $rib_count=0 ?>
	  <?php foreach($gruppi as $nome => $gruppo): ?>
	    <?php $rib_count = $rib_count + $gruppo['ribelle'] ?>
		<?php if($gruppo['data_fine']): ?>
		  <?php printf('(dal %s al %s: %s)', format_date($gruppo['data_inizio'], 'dd/MM/yyyy'), format_date($gruppo['data_fine'], 'dd/MM/yyyy'), $nome ) ?>
	    <?php else: ?>
		  <?php print $nome ?>
	    <?php endif; ?>
	  <?php endforeach; ?>
	</td>
	<td>
	  <?php if($parlamentari->getString(6)!=0): ?>
	    <?php printf('%d su %d votazioni (%01.2f %%)', $rib_count, $parlamentari->getString(6), number_format($rib_count/$parlamentari->getString(6) *100,2)) ?>
	  <?php else: ?>
	    <?php print('0 su 0 votazioni (0%)') ?>
	  <?php endif; ?>
	</td>
	<td>
	  <?php printf('%d su %d votazioni (%01.2f %%)', $parlamentari->getString(6), $numero_votazioni, number_format($parlamentari->getString(6)/$numero_votazioni *100,2)) ?>
	</td>
	<td>
	  <?php printf('%01.2f',$parlamentari->getFloat(7) ) ?><br />
	  <?php printf('%d° su %d %s', $parlamentari->getInt(8), $numero_parlamentari, ($sf_user->getAttribute('ramo')=='C' ? 'deputati' : 'senatori') ) ?>  
	</td>
  </tr>
  <?php endwhile; ?>
</table>