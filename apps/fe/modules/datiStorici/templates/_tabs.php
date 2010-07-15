<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo ($current == 'indice' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('indice di attivit&agrave;', 'datiStorici/indice') ?></h2>
  </li>
  <li class="<?php echo ($current == 'presenze' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('presenze, assenze e missioni', 'datiStorici/presenze') ?></h2>
  </li>
  <li class="<?php echo ($current == 'rilevanza' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('rilevanza degli atti', 'datiStorici/rilevanza') ?></h2>
  </li>
</ul>

