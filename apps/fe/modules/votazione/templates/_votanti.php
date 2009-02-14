<div class="W73_100 float-left"> 
<table class="disegni-decreti column-table">
  <thead>
    <tr>
  	<th scope="col">parlamentare</th>
	<th scope="col">voto</th>
	<th scope="col">circoscrizione</th>
    </tr>
  </thead> 
  <tbody>
  <?php while($votanti->next()): ?>
   <tr> 
  	<th scope="row" <?php echo ( $votanti->getString(8)==1 ? 'class="evident"' :'') ?>><?php echo link_to($votanti->getString(2).' '.$votanti->getString(3), '@parlamentare?id='.$votanti->getInt(1))." (".$votanti->getString(7).")" ?></th>
	<td><?php echo $votanti->getString(6) ?></td>
	<td><?php echo $votanti->getString(5) ?></td>
  </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>