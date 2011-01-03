<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'voti_rilevanti')) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <?php include_partial('votazioneRightColumn', array('query' => $query)) ?>  
    </div>
    <div class="W73_100 float-left">
      <?php include_partial('wikiRelevantVotes') ?>  
      <p>&nbsp;</p>                 
      <?php include_component('votazione', 'keyvotes', array('limit' => '0', 'type' => 'relevant', 'pagina' => 'keyvotes')) ?> 
    </div>
    <div class="clear-both"></div>
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  voti chiave
<?php end_slot() ?>
