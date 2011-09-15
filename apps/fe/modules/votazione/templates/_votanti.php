<table class="disegni-decreti column-table">
  <thead>
    <tr>
  	<th scope="col">parlamentare</th>
	<th scope="col">voto</th>
	<th scope="col">circoscrizione</th>
    </tr>
  </thead> 
  <tbody>
  <?php $tr_class = 'even' ?>
  <?php while($votanti->next()): ?>
   <tr class="<?php echo $tr_class; ?>">
   <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
  	<th scope="row"><?php echo link_to($votanti->getString(2).' '.$votanti->getString(3), '@parlamentare?id='.$votanti->getInt(1))." (".$votanti->getString(7).")".($votanti->getInt(8)==1?'&nbsp;'.image_tag('ribelle_rosso.png', array('align'=>'top')):'').($votanti->getInt(9)==1?'&nbsp;'.image_tag('punto_esclamativo_rosso.png', array('align'=>'top')):'').($votanti->getInt(9)==2?'&nbsp;'.image_tag('punto_esclamativo_rosso.png', array('align'=>'top')):'') ?></th>
	<td><?php echo $votanti->getString(6) ?></td>
	<?php if($votanti->getString(5)!=""): ?>
	  <td><?php echo $votanti->getString(5) ?></td>
	 <?php else: ?>
         <td><p><?php echo '* Senatore a vita' ?></p></td>
        <?php endif; ?>  
  </tr>
  <?php endwhile; ?>
  </tbody>
</table>
