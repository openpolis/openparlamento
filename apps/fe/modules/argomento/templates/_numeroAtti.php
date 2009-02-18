<table class="disegni-decreti column-table">
  <thead>
    <tr>
  	<th scope="col">Atto</th>
	<th scope="col">Camera</th>
	<th scope="col">Senato</th>
    </tr>
  </thead>
 <tbody>
 <?php for ($x=1;$x<count($C_atti);$x++): ?>
   <?php if ($C_atti[$x]!=0 OR $S_atti[$x]!=0) : ?>
   <tr>
     <td><?php echo $arr_tipologia[$x] ?></td> 
     <td><?php echo $C_atti[$x] ?></td>
     <td><?php echo $S_atti[$x] ?></td>  
    </tr>
    <?php endif ?>
 <?php endfor ?>
 </tbody>
</table>
  