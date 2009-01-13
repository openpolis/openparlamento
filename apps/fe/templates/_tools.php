<?php if ($this->getContext()->getModuleName() != 'sfGuardAuth' ||
  $this->getContext()->getActionName() != 'signin'): ?>
  <?php if ($sf_user->isAuthenticated()): ?>
    <div id="logged-in">
      <div class="inner">    	
        <?php echo link_to('[Esci]', 'logout', array('class' => 'logout')); ?>
		<span class="username"><em>Ciao</em>&nbsp;<?php echo $sf_user->getFirstname() ?></span>
        <div class="userdata">
          <?php echo link_to('monitoraggio', 'monitoring') ?>     	
          <span> | </span>
          <?php echo link_to('le tue azioni', '#') ?>       		  
          <span> | </span>
          <?php echo link_to('il tuo profilo', '#') ?>
        </div>       
      </div>
	</div>    
  <?php else: ?>
    <div id="login">
      <div class="inner">
        <?php echo link_to('Registrati', '#', array('class' => 'sign-on')) ?>	
        <span> | </span>
        <?php echo link_to('Entra', 'login', array('class' => 'sign-in')) ?>      
      </div>	
    </div>
  <?php endif; ?>
<?php endif ?>
  

<div id="identity">
  <?php echo link_to(image_tag('logo-open2public.png', array('alt' => 'open 2 public')), '/') ?>	
  &egrave; uno strumento
  <?php echo link_to(image_tag('logo-openpolis.png', array('alt' => 'openpolis')), 'http://www.openpolis.it') ?> 
</div>