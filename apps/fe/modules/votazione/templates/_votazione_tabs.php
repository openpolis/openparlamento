<nav class="row" id="tabs-container">
<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($current == 'votazione' ? 'current' : '' ) ?>">
    <h2><?php echo link_to($ramo." - votazione n. ".$votazione->getNumeroVotazione()." (seduta n. ".$votazione->getOppSeduta()->getNumero(). " del ".format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy').")", '@votazione?'.$votazione->getUrlParams())  ?></h2>
  </li>
</ul>
</nav>
