<table border=1 cellspacing=1 cellpadding=1>
  <tr><th colspan="4">TUTTI I RIBELLI</th></tr>
  <tr>
  	<th>parlamentare</th>
   	<th>gruppo</th>
   	<th>circoscrizione</th>
   	<th>voto</th>
  </tr>
  
  <?php foreach ($ribelli as $cognome => $ribelle): ?>  
    <tr>
  	  <td><?php echo link_to($cognome, '@parlamentare?id='.$ribelle['id']) ?></td>
	  <td><?php echo $ribelle['gruppo'] ?></td>
	  <td><?php echo $ribelle['circoscrizione'] ?></td>
	  <td><?php echo $ribelle['voto'] ?></td>
    </tr>
  <?php endforeach; ?>  
</table>