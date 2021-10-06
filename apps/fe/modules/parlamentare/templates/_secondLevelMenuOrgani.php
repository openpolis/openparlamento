<div class="float-container">
	<ul class="second-level-tabs float-container">
    <li class="<?php echo($current=='overview' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('Overview', $current=='overview'?'#':'@organi?ramo='.$ramo) ?>
		  </h5>
		</li>
    <li class="<?php echo($current=='commissioni' ? 'current' : '' ) ?>">
		  <h5>
		    <?php if ($ramo=='camera') : ?>
	        <?php echo link_to('Commissioni permanenti', $current=='commissioni'?'#':'@commissioni_camera') ?>
	      <?php else : ?>  
	        <?php echo link_to('Commissioni permanenti', $current=='commissioni'?'#':'@commissioni_senato') ?>
	      <?php endif; ?>    
		  </h5>
		</li>
		
    <li class="<?php echo($current=='giunte' ? 'current' : '' ) ?>">
		  <h5>
  	      <?php echo link_to('Giunte', $current=='giunte'?'#':'@giunte?ramo='.$ramo) ?>
		  </h5>
		</li>
	</ul>
</div>