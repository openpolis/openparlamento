<div class="float-container">
	<ul class="second-level-tabs float-container">
    <li class="<?php echo($current=='aggiornamenti' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('Ultimi aggiornamenti', $current=='aggiornamenti'?'#':'@argomento?triple_value='.$triple_value) ?>
		  </h5>
		</li>
    <li class="<?php echo($current=='leggi' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('Disegni di legge', $current=='leggi'?'#':'@argomento_leggi?triple_value='.$triple_value) ?>
		  </h5>
		</li>
    <li class="<?php echo($current=='nonleg' ? 'current' : '' ) ?>">
		  <h5>
	      <?php echo link_to('Atti non legislativi', $current=='voti'?'#':'@argomento_nonleg?triple_value='.$triple_value) ?>
		  </h5>
		</li>

		<?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
      <li class="<?php echo($current=='dep_sioccupano' ? 'current' : '' ) ?>">
  		  <h5>
  	      <?php echo link_to('Deputati', $current=='dep_sioccupano'?'#':'@argomento_sioccupanodi?triple_value='.$triple_value.'&ramo=C') ?>
  		  </h5>
  		</li>
      <li class="<?php echo($current=='sen_sioccupano' ? 'current' : '' ) ?>">
  		  <h5>
  	      <?php echo link_to('Senatori', $current=='sen_sioccupano'?'#':'@argomento_sioccupanodi?triple_value='.$triple_value.'&ramo=S') ?>
  		  </h5>
  		</li>		  
		<?php endif ?>
	</ul>
</div>
