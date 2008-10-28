<h2>Interventi riferiti all'ATTO</h2>
<table>
<tr>
  <th>Data</th>
  <th>Parlamentare</th>
  <th>link</th>
  <th>Tipo intervento</th>
  <th>Sede</th>
</tr>	
<?php foreach($interventi as $intervento): ?>
<?php $interventi_array = explode('@', $intervento['link'] ); ?>
  <?php foreach($interventi_array as $intervento_singolo): ?>  
    <tr>
      <td><?php echo format_date($intervento['data'], 'dd/MM/yyyy') ?></td>
      <td><?php echo link_to($intervento['nome'].' '.$intervento['cognome'], '@parlamentare?id='.$intervento['politico_id']) ?></td>
      <td><?php echo link_to("vai all'intervento", $intervento_singolo) ?></td>
      <td>
<?php switch($intervento['tipo']): ?>
<?php case 'Referente': ?>
Intervento in sede referente
<?php break; ?>
<?php case 'Consultiva': ?>
Intervento in sede consultiva
<?php break; ?>
<?php case 'Assemblea': ?>
Intervento
<?php break; ?>
<?php endswitch; ?>  	
      </td>
      <td><?php echo ($intervento['denominazione'].' '.($intervento['ramo']=='C' ? 'Camera' : 'Senato') ) ?></td>
    </tr>
  <?php endforeach; ?>	
<?php endforeach; ?>
</table>