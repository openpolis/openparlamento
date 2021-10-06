<nav class="row" id="tabs-container">
<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo ($current == 'emendamento' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Emendamento ' . $emendamento->getShortenedTitle(32), '@singolo_emendamento?id='.$emendamento->getId()) ?></h2>
  </li>
</ul>
</nav>
