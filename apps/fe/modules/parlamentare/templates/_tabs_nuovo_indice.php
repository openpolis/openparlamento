<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($ramo == 'camera' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Deputati', '@parlamentari_nuovo_indice?ramo=camera') ?></h2>   
  </li>
  <li class="<?php echo($ramo == 'senato' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Senatori', '@parlamentari_nuovo_indice?ramo=senato') ?></h2>   
  </li>
  <li class="<?php echo($ramo == 'governo' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Membri del Governo', '@parlamentari_nuovo_indice?ramo=governo') ?></h2>   
  </li>
</ul>
