<?php echo use_helper('Parlamentare') ?>

<?php if (count($politici) > 0): ?>
 <div class="evidence-box float-container">
 
  <h5 class="subsection">senatori che si occupano di questo argomento</h5>
   <div class="pad10">
     
  	<ul>
  	  <?php foreach ($politici as $carica_id => $relevance): ?>
  	     <li style="font-size:12px; padding:5px 0 0 0;">
  	    <?php echo link_to_politicoNomeTipoFromCaricaId($carica_id, $relevance); ?>
  	    </li>
  	  <?php endforeach ?>
          <?php if ($n_remaining_politici > 0): ?>
           
             <li style="font-size:12px; padding:5px 0 0 0;">
            ... e altri <?php echo $n_remaining_politici ?> senatori
            </li>
          <?php endif ?>
           <li>&nbsp;</li>
       </ul>
      
  </div>
 </div>

<?php endif ?>