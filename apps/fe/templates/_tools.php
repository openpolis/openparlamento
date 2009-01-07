<div id="login">
  <div class="inner">	
    <?php if ($this->getContext()->getModuleName() != 'sfGuardAuth' ||
            $this->getContext()->getActionName() != 'signin'): ?>
      <?php if ($sf_user->isAuthenticated()): ?>
        <span>ciao, <?php echo $sf_user->getFirstname() ?></span>
        <?php echo link_to('(Esci)', 'logout', array('style'=>'margin-left: 20px')); ?>
      <?php else: ?>
        <?php echo link_to('Registrati', '#', array('class' => 'sign-on')) ?>	
        <span> | </span>
        <?php echo link_to('Entra', 'login', array('class' => 'sign-in')) ?>      
      <?php endif; ?>
    <?php endif ?>
  </div>	
</div>

<div id="identity">
  <?php echo link_to(image_tag('logo-open2public.png', array('alt' => 'open 2 public')), '/') ?>	
  &egrave; uno strumento
  <?php echo link_to(image_tag('logo-openpolis.png', array('alt' => 'openpolis')), 'http://www.openpolis.it') ?> 
</div>