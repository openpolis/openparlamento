<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'voti_chiave')) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <?php include_partial('votazioneRightColumn', array('query' => $query)) ?>  
       <p align=center>
      <?php echo link_to(image_tag('/images/banner_grafico_230x80.png'),'/grafico_distanze/votes_16_C') ?>
      </p>
    </div>
    <div class="W73_100 float-left">
      <?php include_partial('wikiKeyVotes') ?>  
      <p>&nbsp;</p>  
      <?php include_partial('keyvotes', array('votazioni' => $votazioni)) ?> 
    </div>
    <div class="clear-both"></div>
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  voti chiave
<?php end_slot() ?>
