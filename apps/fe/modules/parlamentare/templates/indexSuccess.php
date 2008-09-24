<?php use_helper('Date') ?>

<b><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></b><br />
<img src="http://www.openpolis.it/politician/picture?content_id=<?php echo $parlamentare->getId() ?>" /><br /><br />
<?php echo link_to('la sua pagina su openpolis', 'http://www.openpolis.it/politico/'.$parlamentare->getId()) ?>
<br /><br />
<?php include_partial('cariche', array('parlamentare' => $parlamentare, 'cariche' => $cariche)) ?>
<br />
<br />
<?php include_partial('voti', array('pager' => $pager)) ?>