<table border=1 cellspacing="1" cellpadding="10">
<tr>
  <th colspan="4">ATTI NON LEGISLATIVI</th>	
</tr>	
<tr>
  <th>Tipo atto</th> 
  <th>Sigla e titolo</th>
  <th>Macrostatus</th>  
  <th>data pres.</th>
</tr>
<?php foreach ($pager->getResults() as $atto): ?>
  <tr>
    <td><?php echo $atto->getOppTipoAtto()->getDenominazione() ?></td> 
    <td><?php echo link_to(Text::denominazioneAtto($atto, 'list'), 'atto/index?id='.$atto->getId()) ?></td>  	
    <td></td>
    <td>
      <?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?>
    </td>	
  </tr>
<?php endforeach; ?>
  <tr>
    <td align="center" colspan='4'>
      <?php if ($pager->haveToPaginate()): ?>
        <?php echo link_to('<<', 'atto/list?page=1') ?>
        <?php echo link_to('<', 'atto/list?page='.$pager->getPreviousPage()) ?>
        <?php foreach ($pager->getLinks() as $page): ?>
          <?php echo link_to_unless($page == $pager->getPage(), $page, 'atto/list?page='.$page) ?>
        <?php endforeach; ?>
        <?php echo link_to('>', 'atto/list?page='.$pager->getNextPage()) ?>
          <?php echo link_to('>>', 'atto/list?page='.$pager->getLastPage()) ?>
        <?php endif; ?>    	
    </td>
  </tr>
  <tr>
    <td align="center" colspan='3'>
      <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	</td>
  </tr>
</table>