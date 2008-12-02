<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($sf_user->getAttribute('carica')=='Deputato' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Deputati', '@parlamentari?legislatura=16&carica=Deputato') ?></h2>   
  </li>
  <li class="<?php echo($sf_user->getAttribute('carica')=='Senatore' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Senatori', '@parlamentari?legislatura=16&carica=Senatore') ?></h2>   
  </li>
</ul>