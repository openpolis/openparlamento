<div class="float-container">
	<ul class="second-level-tabs float-container">
    <li class="<?php echo($current=='lista' ? 'current' : '' ) ?>">
		  <h5>
	        <?php echo link_to('Votazioni con maggioranza battuta', $current=='lista'?'#':'/votazioni/maggioranzaSotto/data/desc') ?>  
		  </h5>
		</li>
    <li class="<?php echo($current=='camera' ? 'current' : '' ) ?>">
		  <h5>
	        <?php echo link_to('I deputati che fanno cadere la maggioranza', $current=='camera'?'#':'@parlamentariSotto?ramo=camera') ?>
		  </h5>
		</li>
		<li class="<?php echo($current=='senato' ? 'current' : '' ) ?>">
		  <h5>
	        <?php echo link_to('I senatori che fanno cadere la maggioranza', $current=='senato'?'#':'@parlamentariSotto?ramo=senato') ?>
		  </h5>
		</li>
	</ul>
</div>