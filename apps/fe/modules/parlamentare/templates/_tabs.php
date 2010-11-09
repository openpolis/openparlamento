<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo( (($sf_params->get('ramo')=='camera' && !$gruppi && !$organi) || ($ramo==1 && !$gruppi && !$organi)) ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Deputati', '@parlamentari?ramo=camera') ?></h2>   
  </li>
  <li class="<?php echo($ramo==1 && $gruppi ? 'current' : '' ) ?>">
    <h6><?php echo link_to('Gruppi della Camera '.image_tag('/images/ico-new.png'), '/gruppi_camera') ?></h6>   
  </li>
  <li class="<?php echo($ramo=='camera' && $organi ? 'current' : '' ) ?>">
    <h6><?php echo link_to('Organi della Camera '.image_tag('/images/ico-new.png'), '/organi/camera') ?></h6>   
  </li>
  
  <li class="<?php echo( (($sf_params->get('ramo')=='senato' && !$gruppi && !$organi) || ($ramo==2 && !$gruppi && !$organi)) ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Senatori', '@parlamentari?ramo=senato') ?></h2>   
  </li>
  <li class="<?php echo($ramo==2 && $gruppi ? 'current' : '' ) ?>">
    <h6><?php echo link_to('Gruppi del Senato '.image_tag('/images/ico-new.png'), '/gruppi_senato') ?></h6> 
    <li class="<?php echo($ramo=='senato' && $organi ? 'current' : '' ) ?>">
      <h6><?php echo link_to('Organi del Senato '.image_tag('/images/ico-new.png'), '/organi/senato') ?></h6>   
    </li>  
  </li>

</ul>
