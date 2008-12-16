<div id="login">
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

<?php echo form_tag('#', array("id"=>"search-main")) ?>
  <p>
    <?php echo input_tag('query', '', array('id' => 'search-main-field', 'name' => 'search-field', 'tabindex' => '1') ) ?>
    <?php echo submit_image_tag('btn-cerca.png', array('id' => 'search-main-go', 'alt' => 'cerca', 'name' => 'search-go' )) ?>	
  </p>
</form>

<div id="identity">
  <?php echo link_to(image_tag('logo-open2public.png', array('alt' => 'open 2 public')), '/') ?>	
  &egrave; uno strumento
  <?php echo link_to(image_tag('logo-openpolis.png', array('alt' => 'openpolis')), 'http://www.openpolis.it') ?> 
</div>