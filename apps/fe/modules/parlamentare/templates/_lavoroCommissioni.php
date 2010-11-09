<h3 class="subsection">
  Il quadro generale: quanto lavorano le commissioni
</h3>  

<div style="width: 73%;" class="W73_100 float-left">
  <table class="disegni-decreti column-table lazyload">
    <thead>
      <tr>
        <th scope="col">Commissione:</th>
        <th scope="col">DDL<br/>divenuti legge:</th> 	
        <th scope="col">DDL<br/>sede referente:</th> 	
        <th scope="col">DDL<br/>sede consultiva:</th>
        <th scope="col">Atti non<br/>legislativi:</th>
        <th scope="col">Numero di<br/>sedute:</th>
        <th scope="col">Numero di<br/>interventi</th>
      </tr>
    </thead>

    <tbody>
      <?php $tr_class = 'even'; ?>
<?php foreach ($compara_comm as $k=>$com ) :?>
  <tr class="<?php echo ($tr_class == 'even' ? 'odd' : 'even' ); ?>">
    <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
  <th scope='row'>
   <a href="#<?php echo $k ?>"><?php echo OppSedePeer::retrieveByPk($k)->getDenominazione() ?></a></th>
  <td><?php echo number_format(count(OppAttoPeer::getAttiPerCommissioneLastIter($k,'approvato definitivamente',$leg)), 0, '', '.') ?></td>
  <td><?php echo number_format($com[0], 0, '', '.') ?></td>
  <td><?php echo number_format($com[1], 0, '', '.') ?></td>
  <td><?php echo number_format($com[2], 0, '', '.') ?></td>
  <td><?php echo number_format($com[3], 0, '', '.') ?></td>
  <td><?php echo number_format($com[4], 0, '', '.') ?></td>
  </tr>
<?php endforeach ?>  

  </tbody>
</table>  
  
</div>