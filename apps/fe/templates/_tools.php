<?php if ($this->getContext()->getModuleName() != 'sfGuardAuth' ||
  $this->getContext()->getActionName() != 'signin'): ?>
  <?php if ($sf_user->isAuthenticated()): ?>
    <div id="logged-in">
      <div class="inner">    	
        <?php echo link_to('[Esci]', 'logout', array('class' => 'logout')); ?>
		    <span class="username"><?php echo $sf_user->getFirstname() ?>&nbsp;
		      <?php if ($sf_user->hasCredential('premium')): ?>
		        <em>(premium)</em>
		      <?php endif ?>
		      <?php if ($sf_user->hasCredential('adhoc')): ?>
		        <em>(adhoc)</em>
		      <?php endif ?>
		      <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>
		        <!-- <em> (<?php //echo link_to('attiva premium gratis!','/sottoscrizioni_pro',array('style' => 'display:inline; font-weight:normal')) ?>)</em> -->
		      <?php endif ?>  
		    </span>
        <div class="userdata">
          <?php echo link_to('<strong>monitoraggio</strong>', 'monitoring') ?>     	
          <span> | </span>
          <?php echo link_to('profilo',
                             "http://".sfConfig::get('sf_remote_guard_host',
                                                     'op_accesso.openpolis.it').
                             (SF_ENVIRONMENT!='prod'?'/be_'.SF_ENVIRONMENT.'.php':'').
                             "/aggiorna_profilo"
          ) ?>
        </div>       
      </div>
	</div>    
  <?php else: ?>
    <div id="login">
      <div class="inner">
        <?php echo link_to('Registrati', 
                            "http://".sfConfig::get('sf_remote_guard_host',
                                                    'op_accesso.openpolis.it').
                            (SF_ENVIRONMENT!='prod'?'/be_'.SF_ENVIRONMENT.'.php':'').
                            "/aggiungi_utente" , 
                           array('class' => 'sign-on')) ?>	
        <span> | </span>
        <?php echo link_to('Entra', 'login', array('class' => 'sign-in')) ?>      
      </div>	
    </div>
  <?php endif; ?>
<?php endif ?>
  

<div id="identity">
  <?php echo link_to(image_tag('logo-openparlamento_new.png', array('alt' => 'openparlamento')), '@homepage') ?>	
  <?php echo link_to(image_tag('logo-openpolis_new.png', array('alt' => 'openpolis')), 'http://associazione.openpolis.it') ?> 
</div>