<div id="login">
  <?php echo link_to('Registrati', '#', array('class' => 'sign-on')) ?>	
  <span> | </span>
  <?php echo link_to('Entra', '#', array('class' => 'sign-in')) ?>  
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