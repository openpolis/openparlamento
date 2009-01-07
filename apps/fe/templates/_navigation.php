<?php echo form_tag('#', array("id"=>"search-main")) ?>
  <p>
    <?php echo input_tag('query', '', array('id' => 'search-main-field', 'name' => 'search-field', 'tabindex' => '1') ) ?>
    <?php echo submit_image_tag('btn-cerca.png', array('id' => 'search-main-go', 'alt' => 'cerca', 'name' => 'search-go' )) ?>	
  </p>
</form>


<ul>
  <li>
    <?php if($this->getContext()->getModuleName() == 'atto'): ?>
      <?php echo link_to('Atti', 'atto/disegnoList', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Atti', 'atto/disegnoList') ?>
    <?php endif; ?>
  </li>
  <li>
    <?php if($this->getContext()->getModuleName() == 'votazione'): ?>
      <?php echo link_to('Votazioni', '@votazioni', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Votazioni', '@votazioni') ?>
    <?php endif; ?>
  </li>   
  <li>
    <?php if($this->getContext()->getModuleName() == 'parlamentare'): ?>
      <?php echo link_to('Parlamentari', '@parlamentari?ramo=camera', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Parlamentari', '@parlamentari?ramo=camera') ?>
    <?php endif; ?>
  </li>
  <li><?php echo link_to('Argomenti', '@argomenti') ?></li>
  <li><?php echo link_to('Comunit&agrave;', '#') ?></li>
  <li><?php echo link_to('Blog', '#') ?></li>
  <?php if ($sf_user->isAuthenticated()): ?>
    <li><?php echo link_to('Monitoring', 'monitoring') ?></li>
  <?php endif; ?>
  
</ul>