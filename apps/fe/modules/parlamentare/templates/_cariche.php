<table border=1 cellspacing=1 cellpadding=1>
  <tr>
    <th colspan="12">ATTIVITA' PARLAMENTARE</th>	
  </tr>
  <tr>
    <th>dal</th>
	<th>al</th> 	
    <th>carica</th>
	<th>gruppo</th>
	<th>circoscrizione</th>
	<th>ribelle</th>
	<th>presente</th>
	<th>assente</th>
	<th>in missione</th>
	<th>indice di attivit&agrave;<br />(min 0 - max 10)</th> 	
  </tr>
<?php foreach ($cariche as $id => $carica): ?>
  <?php //$presenze_totali = $carica['Astenuto'] + $carica['Contrario'] + $carica['Favorevole'] + $carica['Partecipante votazione non valida'] + 
	                    $carica['Presidente di turno'] + $carica['Richiedente la votazione e non votante'] + $carica['Voto segreto'] ?>
  <?php $numero_votazioni_totali = $carica['Astenuto'] + $carica['Contrario'] + $carica['Favorevole'] + $carica['Partecipante votazione non valida'] + 
	                        $carica['Presidente di turno'] + $carica['Richiedente la votazione e non votante'] + $carica['Voto segreto'] +
							$carica['Assente'] + $carica['In missione'] ?>
  <tr>
    <td><?php echo format_date($carica['data_inizio'], 'dd/MM/yyyy') ?></td>
	<td>
      <?php if($carica['data_fine']): ?>
        <?php echo format_date($carica['data_fine'], 'dd/MM/yyyy') ?>
      <?php else: ?>
	    in carica
      <?php endif; ?>		
	</td> 	
    <td><?php echo $carica['carica'] ?></td>
	<td>
	  <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($id) ?>	
	  <?php foreach($gruppi as $nome => $gruppo): ?>
	    <?php if($gruppo['data_fine']): ?>
		  <?php printf('dal %s al %s : %s', format_date($gruppo['data_inizio'], 'dd/MM/yyyy'), format_date($gruppo['data_fine'], 'dd/MM/yyyy'), $nome ) ?><br />
	    <?php else: ?>
		  <?php printf('dal %s : %s', format_date($gruppo['data_inizio'], 'dd/MM/yyyy'), $nome ) ?><br />
		<?php endif; ?>
	  <?php endforeach; ?>
	</td>
	<td><?php echo $carica['circoscrizione'] ?></td>  	
    <td>
      <?php $presenze_totali = 0 ?>
	  <?php foreach($gruppi as $nome => $gruppo): ?>
	    <?php //$ribelle_count=$parlamentare->getRibelleReport($id, ($carica['carica']=='Deputato' ? 'C' : 'S'), $nome, format_date($gruppo['data_inizio'], 'yyyy-MM-dd'), format_date($gruppo['data_fine'], 'yyyy-MM-dd')); ?>
        <?php $presenze = OppCaricaPeer::doSelectPresenzePerGruppo($id, format_date($gruppo['data_inizio'], 'yyyy-MM-dd'), format_date($gruppo['data_fine'], 'yyyy-MM-dd')) ?>
		<?php if($presenze!=0): ?>
		  <?php printf('%d volte su %d voti (%01.2f %%)', $gruppo['ribelle'], $presenze, number_format($gruppo['ribelle']/$presenze *100,2)) ?><br />
	    <?php else: ?>
		  <?php print('0 volte su 0 voti (0%)') ?><br />
		<?php endif; ?>
		<?php $presenze_totali = $presenze_totali + $presenze ?>
	  <?php endforeach; ?>  	
    </td>
	<td><?php printf('%d volte su %d voti (%01.2f %%)', $presenze_totali, $numero_votazioni_totali, number_format($presenze_totali/$numero_votazioni_totali *100,2)) ?></td>
	<td><?php printf('%d volte su %d voti (%01.2f %%)', $carica['Assente'], $numero_votazioni_totali, number_format($carica['Assente']/$numero_votazioni_totali *100,2)) ?></td>
	<td><?php printf('%d volte su %d voti (%01.2f %%)', $carica['In missione'], $numero_votazioni_totali, number_format($carica['In missione']/$numero_votazioni_totali *100,2)) ?></td>
    <td>
	  <?php printf('%01.2f',$carica['Indice'] ) ?><br />
	  <?php printf('%d° su %d %s', $carica['Posizione'], 600, ($carica['carica']=='Deputato' ? 'deputati' : 'senatori') ) ?>  
	</td>
  </tr>
<?php endforeach; ?>
</table>