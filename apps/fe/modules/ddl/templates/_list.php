<table border=1 cellspacing="1" cellpadding="10">
<tr>
  <th colspan="3">DISEGNI DI LEGGE</th>	
</tr>	
<tr> 
  <th>Sigla e titolo</th>
  <th>Macrostatus</th>  
  <th>data pres.</th>
</tr>
<?php foreach ($pager->getResults() as $ddl): ?>
  <tr>
    <td><?php echo link_to($ddl->getRamo().'.'.$ddl->getNumfase().' '.$ddl->getTitolo(), 'ddl/index?id='.$ddl->getId()) ?></td>  	
    <td></td>
    <td>
      <?php echo format_date($ddl->getDataPres(), 'dd/MM/yyyy') ?>
    </td>	
  </tr>
<?php endforeach; ?>
  <tr>
    <td align="center" colspan='3'>
      <?php if ($pager->haveToPaginate()): ?>
        <?php echo link_to('<<', 'ddl/list?page=1') ?>
        <?php echo link_to('<', 'ddl/list?page='.$pager->getPreviousPage()) ?>
        <?php foreach ($pager->getLinks() as $page): ?>
          <?php echo link_to_unless($page == $pager->getPage(), $page, 'ddl/list?page='.$page) ?>
        <?php endforeach; ?>
        <?php echo link_to('>', 'ddl/list?page='.$pager->getNextPage()) ?>
          <?php echo link_to('>>', 'ddl/list?page='.$pager->getLastPage()) ?>
        <?php endif; ?>    	
    </td>
  </tr>
  <tr>
    <td align="center" colspan='3'>
      <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	</td>
  </tr>
</table>