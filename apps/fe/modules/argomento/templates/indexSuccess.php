<?php use_helper('Javascript') ?>

<h3>argomento: <?php echo $argomento->getDenominazione() ?></h3>
<br /><br />

<div id="container">
  <h4>Teseo:</h4>
  <?php foreach($tesei as $teseo): ?>
    <?php echo link_to_remote($teseo->getDenominazione(), array(
      'update' => 'container',
      'url'    => 'argomento/elencoDdl?argomento_id='.$argomento->getId().'&teseo_id='.$teseo->getId(),
  )) ?>&nbsp;-
  <?php endforeach; ?>

  <br /><br />
  <h4>ddl:</h4>
  <div id="ddl_list">
    <?php include_component( 'argomento', 'elencoDdl', array('teseo_id'=> $teseo_id) ) ?>
  </div>
</div>