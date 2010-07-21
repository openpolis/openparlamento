<ul id="content-tabs" class="float-container tools-container small-titles">
  <li class="<?php echo ($current == 'indice' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('indice di attivit&agrave;', 'datiStorici/indice') ?></h2>
  </li>
  <li class="<?php echo ($current == 'rilevanzaAtti' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('rilevanza degli atti', 'datiStorici/rilevanzaAtti') ?></h2>
  </li>
  <li class="<?php echo ($current == 'rilevanzaTag' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('rilevanza degli argomenti', 'datiStorici/rilevanzaTag') ?></h2>
  </li>
  <li class="<?php echo ($current == 'interessi' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('interessi dei parlamentari', 'datiStorici/interessi') ?></h2>
  </li>
  <li class="<?php echo ($current == 'presenze' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('presenze, assenze e missioni', 'datiStorici/presenze') ?></h2>
  </li>
</ul>

