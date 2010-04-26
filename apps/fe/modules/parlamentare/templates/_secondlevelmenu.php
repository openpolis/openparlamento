<div class="float-container">
	<ul class="second-level-tabs float-container">
    <li class="<?php echo($current=='cosa' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('Cosa fa', $current=='cosa'?'#':'@parlamentare?id='.$parlamentare_id) ?>
		  </h5>
		</li>
    <li class="<?php echo($current=='atti' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('I suoi atti', $current=='atti'?'#':'@parlamentare_atti?id='.$parlamentare_id) ?>
		  </h5>
		</li>
		<!--
		<li class="<?php //echo($current=='emendamenti' ? 'current' : '' ) ?>">
		  <h5>
	      <?php //echo link_to('I suoi emendamenti '.image_tag('/images/ico-new.png'), $current=='emendamenti'?'#':'@parlamentare_emendamenti?id='.$parlamentare_id) ?>
		 </h5>
		</li>
		-->
    <li class="<?php echo($current=='voti' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('I suoi voti', $current=='voti'?'#':'@parlamentare_voti?id='.$parlamentare_id) ?>
		  </h5>
		</li>
    <li class="<?php echo($current=='interventi' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('I suoi interventi', $current=='interventi'?'#':'@parlamentare_interventi?id='.$parlamentare_id) ?>
		 </h5>
		</li>
	</ul>
</div>
