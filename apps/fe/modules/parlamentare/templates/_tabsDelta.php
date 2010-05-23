<ul id="content-tabs" class="float-container tools-container">
  <li class="<?php echo($dato=='presenze' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Presenze', "@parlamentari_tabella_delta?data=$data&ramo=$ramo&dato=presenze") ?></h2>   
  </li>
  <li class="<?php echo($dato=='assenze' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Assenze', "@parlamentari_tabella_delta?data=$data&ramo=$ramo&dato=assenze") ?></h2>   
  </li>
  <li class="<?php echo($dato=='missioni' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Missioni', "@parlamentari_tabella_delta?data=$data&ramo=$ramo&dato=missioni") ?></h2>   
  </li>
  <li class="<?php echo($dato=='ribellioni' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Ribellioni', "@parlamentari_tabella_delta?data=$data&ramo=$ramo&dato=ribellioni") ?></h2>   
  </li>
  <li class="<?php echo($dato=='indice' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Indice', "@parlamentari_tabella_delta?data=$data&ramo=$ramo&dato=indice") ?></h2>   
  </li>
</ul>
