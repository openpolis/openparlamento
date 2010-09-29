<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($sf_params->get('ramo', 'camera')=='camera' && !$gruppi ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Deputati', '@parlamentari?ramo=camera') ?></h2>   
  </li>
  <li class="<?php echo($ramo==1 && $gruppi ? 'current' : '' ) ?>">
    <h6><?php echo link_to('Gruppi Camera', '/camera/GruppiCamera') ?></h6>   
  </li>
  <li class="<?php echo($ramo==1 && $compare ? 'current' : '' ) ?>">
    <h6><?php echo link_to('Confronta deputati', '/parlamentare/comparaDeputati?id1=4573&id2=161&ramo=1') ?></h6>   
  </li>
  <li class="<?php echo($sf_params->get('ramo', 'camera')=='senato' && !$gruppi ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Senatori', '@parlamentari?ramo=senato') ?></h2>   
  </li>
  <li class="<?php echo($ramo==2 && $gruppi ? 'current' : '' ) ?>">
    <h6><?php echo link_to('Gruppi Senato', '/senato/GruppiSenato') ?></h6>   
  </li>
<li class="<?php echo($ramo==2 && $compare ? 'current' : '' ) ?>">
    <h6><?php echo link_to('Confronta senatori', '/parlamentare/comparaDeputati?id1=303095&id2=332961&ramo=2') ?></h6>   
  </li>
</ul>
