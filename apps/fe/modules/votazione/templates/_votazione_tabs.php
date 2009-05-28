<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($current == 'votazione' ? 'current' : '' ) ?>">
    <h2><?php echo link_to($ramo." - votazione n. ".$votazione->getNumeroVotazione()." (seduta n. ".$votazione->getOppSeduta()->getNumero(). " del ".format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy').")", '@votazione?id='.$votazione->getId())  ?></h2>
  </li>
  <li class="<?php echo($current == 'commenti' ? 'current' : '' ) ?>">
    <h4><?php echo link_to(format_number_choice('[0]Lascia un commento|[1]Un commento|(1,+Inf]%1% commenti', 
                           array('%1%' => $nb_comments), $nb_comments), '@commenti_votazione?id='.$votazione->getId()) ?></h4>
  </li>
</ul>

