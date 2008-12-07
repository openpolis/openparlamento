<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($sf_params->get('ramo', 'camera')=='camera' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Deputati', '@parlamentari?ramo=camera') ?></h2>   
  </li>
  <li class="<?php echo($sf_params->get('ramo', 'camera')=='senato' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Senatori', '@parlamentari?ramo=senato') ?></h2>   
  </li>
</ul>