<?php foreach ($atti as $atto) :?>
<?php echo $atto->getTitolo()."-".$atto->getStatoFase()." - ".$atto->getStatoLastDate('d/m/Y') ?>
<br/>
<?php endforeach ?>