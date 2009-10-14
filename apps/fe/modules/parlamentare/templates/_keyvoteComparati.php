<div class="W73_100 float-left">
<?php if (count($lanci)>0) : ?>  
<h4 class="subsection">Confronto nei <?php echo count($lanci) ?> voti chiave</h4>
<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col">Voto chiave:</th>
      <th scope="col"><?php echo $parlamentare1->getOppPolitico()->getNome().' '.$parlamentare1->getOppPolitico()->getCognome().':' ?></th> 	
      <th scope="col"><?php echo $parlamentare2->getOppPolitico()->getNome().' '.$parlamentare2->getOppPolitico()->getCognome().':' ?></th>
       <th scope="col">Esito della votazione:</th>			
    </tr>
  </thead>

  <tbody>
  <?php foreach ($lanci as $lancio) : ?>
<tr>
        <th scope="row">
          <p>
          <?php echo link_to(($lancio[0]->getTitoloAggiuntivo()) ? $lancio[0]->getTitoloAggiuntivo() : $lancio[0]->getTitolo(),       'votazione/index?id='.$lancio[0]->getId()) ?>
          </p>         
       </th>
       <?php if ($lancio[2]!=$lancio[3]) : ?>
          <td style="background-color:#fba6b6;"><p><?php echo $lancio[2] ?></p></td>
          <td style="background-color:#fba6b6;"><p><?php echo $lancio[3] ?></p></td>
       <?php else : ?>   
          <td style="background-color:#c0fba6;"><p><?php echo $lancio[2] ?></p></td>
          <td style="background-color:#c0fba6;"><p><?php echo $lancio[3] ?></p></td>
       <?php endif ?>  
       <td>
		  <?php if($lancio[0]->getEsito()=='APPROVATA'): ?>
		    <?php $class = "green thumb-approved"; ?>
		  <?php elseif($lancio[0]->getEsito()=='RESPINTA'): ?>
		    <?php $class = "red thumb-rejected"; ?>
		  <?php else: ?>
		    <?php $class = ""; ?>
                  <?php endif; ?>
            <span class="<?php echo $class ?>"><?php echo $lancio[0]->getEsito() ?></span>      	
        </td>   

</tr>
<?php endforeach ?>
</tbody>
</table>
<?php else : ?>
  <?php echo "i due parlamentari non erano in carica contemporaneamente alla data  di nessun voto chiave"?>
<?php endif; ?>  
</div>