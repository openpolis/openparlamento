<?php echo use_helper('Parlamentare') ?>


<div class="float-left" style="width: 33%">
  <?php if (count($politici) > 0): ?>
  	<h6>si occupano di questo argomento:</h6>
  	<p class="pad10">
  	  <?php foreach ($politici as $carica_id => $relevance): ?>
  	    <?php echo link_to_politicoNomeTipoFromCaricaId($carica_id, $relevance); ?>
  	    &nbsp;&nbsp;
  	  <?php endforeach ?>
  	</p>
    <?php if ($n_remaining_politici > 0): ?>
    <p class="pad10">
     ... e altri <?php echo $n_remaining_politici ?> politici
     </p>
    <?php endif ?>
  <?php else: ?>
    <h6>Nessun politico si occupa di questo argomento</h6>
  <?php endif ?>
</div>


