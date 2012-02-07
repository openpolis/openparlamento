<nav class="row" id="tabs-container">
    <ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($current == 'voti_chiave' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Voti chiave', '@votichiave') ?></h2>   
  </li>
 
  <li class="<?php echo($current == 'maggioranza_sotto' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Maggioranza battuta', '@maggioranzaSotto') ?></h2>   
  </li>
  <li class="<?php echo($current == 'maggioranza_salva' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Maggioranza salvata', '@maggioranzaSalva') ?></h2>   
  </li>
  <li class="<?php echo($current == 'voti_tutti' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Tutte le votazioni', '@votazioni') ?></h2>   
  </li>
</ul>
</nav>