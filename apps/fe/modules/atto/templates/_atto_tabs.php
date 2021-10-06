<nav class="row" id="tabs-container">
    <ul id="content-tabs" class="float-container tools-container">
      <li class="<?php echo ($current == 'atto' ? 'current' : '' ) ?>">
        <h2><?php echo link_to(Text::denominazioneAttoShort($atto), '@singolo_atto?id='.$atto->getId()) ?></h2>
      </li>
      <?php if ($nb_emendamenti > 0): ?>
        <li class="<?php echo($current == 'emendamenti' ? 'current' : '' ) ?>">
          <h5><?php echo link_to(format_number_choice('[1]Un emendamento|(1,+Inf]%1% emendamenti', 
                                 array('%1%' => $nb_emendamenti), $nb_emendamenti), '@emendamenti_atto?id='.$atto->getId()) ?></h5>
        </li>    
      <?php endif ?>
      <!--
      <li class="<?php //echo($current == 'commenti' ? 'current' : '' ) ?>">
        <h5><?php //echo link_to(format_number_choice('[0]Lascia un commento|[1]Un commento|(1,+Inf]%1% commenti', array('%1%' => $nb_comments), $nb_comments), '@commenti_atto?id='.$atto->getId()) ?></h5>
      </li>
    -->
    </ul>
</nav>