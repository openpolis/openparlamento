<nav class="row" id="tabs-container">
<ul id="content-tabs" class="float-container tools-container small-titles">
  <li class="<?php echo ($current == 'indicepresenze' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('indice di attivit&agrave; e presenze', 'datiStorici/indicePresenze') ?></h2>
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
</ul>
</nav>