<?php use_helper('Javascript') ?>

<h4>Teseo:</h4>
<?php foreach($tesei as $teseo): ?>
  <?php if($teseo->getId() != $teseo_id): ?>
    <?php echo link_to_remote($teseo->getDenominazione(), array(
          'update' => 'container',
          'url'    => 'argomento/elencoDdl?argomento_id='.$argomento->getId().'&teseo_id='.$teseo->getId(),
    )) ?>&nbsp;-
  <?php else: ?>
    <?php echo $teseo->getDenominazione() ?>&nbsp;-
  <?php endif; ?>
<?php endforeach; ?>

<br /><br />
<h4>ddl:</h4>
<div id="ddl_list">
  <?php include_component( 'argomento', 'elencoDdl', array('teseo_id'=> $teseo_id) ) ?>
</div>