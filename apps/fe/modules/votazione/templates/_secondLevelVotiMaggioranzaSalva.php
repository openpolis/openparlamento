<div class="float-container">
	<ul class="second-level-tabs float-container">
    <li class="<?php echo($current=='lista' ? 'current' : '' ) ?>">
		  <h5>
	        <?php echo link_to('Votazioni con maggioranza salvata', $current=='lista'?'#':'/votazioni/maggioranzaSalva/data/desc') ?>  
		  </h5>
		</li>
    <li class="<?php echo($current=='camera' ? 'current' : '' ) ?>">
		  <h5>
	        <?php echo link_to('I deputati che salvano la maggioranza', $current=='camera'?'#':'@parlamentariSalva?ramo=camera') ?>
		  </h5>
		</li>
		<li class="<?php echo($current=='senato' ? 'current' : '' ) ?>">
		  <h5>
	        <?php echo link_to('I senatori che salvano la maggioranza', $current=='senato'?'#':'@parlamentariSalva?ramo=senato') ?>
		  </h5>
		</li>
	</ul>
</div>