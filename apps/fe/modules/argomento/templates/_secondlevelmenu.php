<div class="float-container">
	<ul class="second-level-tabs float-container">
    <li class="<?php echo($current=='aggiornamenti' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('Ultimi aggiornamenti', $current=='aggiornamenti'?'#':'@argomento?triple_value='.$triple_value) ?>
		  </h5>
		</li>
    <li class="<?php echo($current=='leggi' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('Leggi in discussione', $current=='leggi'?'#':'@argomento_leggi?triple_value='.$triple_value) ?>
		  </h5>
		</li>
    <li class="<?php echo($current=='nonleg' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('Atti non legislativi', $current=='voti'?'#':'@argomento_nonleg?triple_value='.$triple_value) ?>
		  </h5>
		</li>
	</ul>
</div>
