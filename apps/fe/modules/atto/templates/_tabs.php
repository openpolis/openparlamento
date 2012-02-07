<nav class="row" id="tabs-container">
<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($current == 'evidenza' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('In evidenza', '@attiEvidenza') ?></h2>   
  </li>
  <li class="<?php echo($current == 'disegni' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Disegni di legge', '@attiDisegni') ?></h2>   
  </li>
  <li class="<?php echo($current == 'decreti' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Decreti legge', '@attiDecretiLegge') ?></h2>   
  </li>
  <li class="<?php echo($current == 'decrleg' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Decreti legislativi', '@attiDecretiLegislativi') ?></h2>   
  </li>
  <li class="<?php echo($current == 'nonleg' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Atti non legislativi', '@attiNonLegislativi') ?></h2>   
  </li>  
</ul>
</nav>