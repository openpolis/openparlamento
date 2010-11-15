<div id="second-level-menu-argomenti" class="float-container">
	<ul class="second-level-tabs float-container">
    <li class="<?php echo($current=='overview' ? 'current' : '' ) ?>">
		  <h5>
		    <?php if ($current == 'overview'): ?>
          <span>Overview</span>
		    <?php else: ?>
  	      <?php echo link_to('Overview', 
  	                         '@monitoring_tags?user_token='. sfContext::getInstance()->getUser()->getToken()) ?>
		    <?php endif ?>
		  </h5>
		</li>
    <li class="<?php echo($current=='deputati' ? 'current' : '' ) ?>">
		  <h5>
		    <?php if ($current == 'deputati'): ?>
          <span>Classifiche Deputati</span>
		    <?php else: ?>
  	      <?php echo link_to('Classifiche Deputati', 
  	                         '@monitoring_tags_deputati?user_token='. sfContext::getInstance()->getUser()->getToken()) ?>
		    <?php endif ?>
		  </h5>
		</li>
		
		<li class="<?php echo($current=='senatori' ? 'current' : '' ) ?>">
		  <h5>
		    <?php if ($current == 'senatori'): ?>
          <span>Classifiche Senatori</span>
		    <?php else: ?>
  	      <?php echo link_to('Classifiche Senatori', 
  	                         '@monitoring_tags_senatori?user_token='. sfContext::getInstance()->getUser()->getToken()) ?>
		    <?php endif ?>
		 </h5>
		</li>
		
	</ul>
</div>