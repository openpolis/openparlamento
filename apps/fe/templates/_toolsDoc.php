<?php if ($this->getContext()->getModuleName() != 'sfGuardAuth' ||
  $this->getContext()->getActionName() != 'signin'): ?>
  <?php if ($sf_user->isAuthenticated()): ?>
    <div id="logged-in">
      <div class="inner">    	
        <?php echo link_to('[Esci]', 'logout', array('class' => 'logout')); ?>
		<span class="username"><em>Ciao</em>&nbsp;<?php echo $sf_user->getFirstname() ?></span>
        <div class="userdata">
          <?php echo link_to('<strong>il tuo monitoraggio</strong>', 'monitoring') ?>     	
          <span> | </span>
          <?php echo link_to('il tuo profilo',
                             "http://".sfConfig::get('app_remote_guard_host',
                                                     'lapgu.accesso.openpolis.it').
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
                            "http://".sfConfig::get('app_remote_guard_host',
                                                    'lapgu.accesso.openpolis.it').
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
  <?php echo link_to(image_tag('logo-open2public.png', array('alt' => 'open 2 public')), '/') ?>	
</div>