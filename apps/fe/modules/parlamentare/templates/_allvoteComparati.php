<div class="W73_100 float-left">
<h4 class="subsection">Confronto nelle <?php echo $numero_voti ?> votazioni in cui sono stati entrambi presenti</h4>
<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col">Votazione:</th>
      <th scope="col"><?php echo $parlamentare1->getOppPolitico()->getNome().' '.$parlamentare1->getOppPolitico()->getCognome().':' ?></th> 	
      <th scope="col"><?php echo $parlamentare2->getOppPolitico()->getNome().' '.$parlamentare2->getOppPolitico()->getCognome().':' ?></th>
       <th scope="col">Esito della votazione:</th>			
    </tr>
  </thead>

  <tbody>
<?php foreach ($pager->getResults() as $votazione) : ?>
<tr>
        <th scope="row">
          <p><?php echo link_to($votazione->getTitolo(), '@votazione?'.$votazione->getUrlParams()) ?></p>
         
       </th>
       <?php if ($arr1[$votazione->getId()]!=$arr2[$votazione->getId()]) : ?>
          <td style="background-color:#fba6b6;"><p><?php echo $arr1[$votazione->getId()] ?></p></td>
          <td style="background-color:#fba6b6;"><p><?php echo $arr2[$votazione->getId()] ?></p></td>
       <?php else : ?>   
          <td style="background-color:#c0fba6;"><p><?php echo $arr1[$votazione->getId()] ?></p></td>
          <td style="background-color:#c0fba6;"><p><?php echo $arr2[$votazione->getId()] ?></p></td>
       <?php endif ?>  
       <td>
		  <?php if($votazione->getEsito()=='APPROVATA'): ?>
		    <?php $class = "green thumb-approved"; ?>
		  <?php elseif($votazione->getEsito()=='RESPINTA'): ?>
		    <?php $class = "red thumb-rejected"; ?>
		  <?php else: ?>
		    <?php $class = ""; ?>
                  <?php endif; ?>
            <span class="<?php echo $class ?>"><?php echo $votazione->getEsito() ?></span>      	
        </td>   

</tr>
<?php endforeach ?>
</tbody>
<tfoot>		  		  
    <tr>
      <td colspan="4" align="center">
        <?php echo pager_navigation($pager, 'parlamentare/comparaParlamentari?id1='.$parlamentare1->getId().'&id2='.$parlamentare2->getId()) ?>
      </td>	
    </tr>
    <tr>
      <td colspan="4" align="center">
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	  </td>
    </tr>
  </tfoot>  		
</table>
</div>