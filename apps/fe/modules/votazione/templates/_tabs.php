<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($current == 'voti_chiave' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Voti chiave', 'votazione/keyvotes') ?></h2>   
  </li>
 
  <li class="<?php echo($current == 'maggioranza_sotto' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Maggioranza battuta', 'votazione/maggioranzaSotto') ?></h2>   
  </li>
  <li class="<?php echo($current == 'maggioranza_salva' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Maggioranza salvata', 'votazione/maggioranzaSalva') ?></h2>   
  </li>
  <li class="<?php echo($current == 'voti_tutti' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Tutte le votazioni', 'votazione/list') ?></h2>   
  </li>
</ul>
