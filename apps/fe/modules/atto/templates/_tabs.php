<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($this->getContext()->getActionName()=='disegnoList' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Disegni di legge', 'atto/disegnoList') ?></h2>   
  </li>
  <li class="<?php echo($this->getContext()->getActionName()=='decretoList' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Decreti legge', 'atto/decretoList') ?></h2>   
  </li>
  <li class="<?php echo($this->getContext()->getActionName()=='decretoLegislativoList' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Decreti legislativi', 'atto/decretoLegislativoList') ?></h2>   
  </li>
  <li class="<?php echo($this->getContext()->getActionName()=='attoNonLegislativoList' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Atti non legislativi', '@attiNonLegislativi') ?></h2>   
  </li>  
</ul>