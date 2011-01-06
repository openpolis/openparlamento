<div class="float-container">
	<ul class="second-level-tabs float-container">
    <li class="<?php echo($current=='lista' ? 'current' : '' ) ?>">
		  <h5>
		    <?php if ($ramo=='camera' || $ramo==1) :?>
	        <?php echo link_to('Tutti i deputati', $current=='lista'?'#':'/parlamentari/camera/nome/asc') ?>
	      <?php else :?>
	        <?php echo link_to('Tutti i senatori', $current=='lista'?'#':'/parlamentari/senato/nome/asc') ?>
	      <?php endif; ?>    
		  </h5>
		</li>
    <li class="<?php echo($current=='confronta' ? 'current' : '' ) ?>">
		  <h5>
	      <?php if ($ramo=='camera' || $ramo==1) :?>
	        <?php echo link_to('Confronta i deputati', $current=='confronta'?'#':'/parlamentare/comparaDeputati?id1=4573&id2=161&ramo=1') ?>
	      <?php else :?>
	        <?php echo link_to('Confronta i senatori', $current=='confronta'?'#':'/parlamentare/comparaDeputati?id1=303095&id2=332961&ramo=2') ?>
	      <?php endif; ?>
		  </h5>
		</li>
		<li class="<?php echo($current=='giorni_di_carica' ? 'current' : '' ) ?>">
		  <h5>
		    <?php if ($ramo=='camera' || $ramo==1) :?>
	        <?php echo link_to('Da quanto tempo sono in parlamento '.image_tag('/images/ico-new.png'), $current=='giorni_di_carica'?'#':'@giorni_di_carica?ramo=camera') ?>
	      <?php else :?>
	        <?php echo link_to('Da quanto tempo sono in parlamento '.image_tag('/images/ico-new.png'), $current=='giorni_di_carica'?'#':'@giorni_di_carica?ramo=camera') ?>
	      <?php endif; ?>    
		  </h5>
		</li>
		<li class="<?php echo($current=='distanze' ? 'current' : '' ) ?>">
		  <h5>
	      <?php if ($ramo=='camera' || $ramo==1) :?>
	        <?php echo link_to('Le distanze tra i deputati', $current=='distanze'?'#':'/grafico_distanze/votes_16_C') ?>
	      <?php else :?>
	        <?php echo link_to('Le distanze tra i senatori', $current=='distanze'?'#':'/grafico_distanze/votes_16_S') ?>
	      <?php endif; ?>
		 </h5>
		</li>
		
	</ul>
</div>