<nav class="row" id="tabs-container">
<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo ($current == 'emendamento' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Emendamento ' . $emendamento->getShortenedTitle(32), '@singolo_emendamento?id='.$emendamento->getId()) ?></h2>
  </li>
  <li class="<?php echo($current == 'commenti' ? 'current' : '' ) ?>">
    <h5><?php echo link_to(format_number_choice('[0]Lascia un commento|[1]Un commento|(1,+Inf]%1% commenti', 
                           array('%1%' => $nb_comments), $nb_comments), '@commenti_emendamento?id='.$emendamento->getId()) ?></h5>
  </li>
</ul>
</nav>
