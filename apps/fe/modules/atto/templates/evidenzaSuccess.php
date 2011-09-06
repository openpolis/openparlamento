<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'evidenza')) ?>

<div id="content" class="tabbed float-container">

  <div id="main">
    <?php /* 
    <div class="W25_100 float-right">
      Contenuto da mettere in spalla
	  </div>
    */ ?>

    <div class="W100_100 float-left">
        <?php include_partial('evidenzaWiki') ?>      		
        <p>&nbsp;</p>                 
        <?php include_component('atto', 'evidenza', array('limit' => '0')) ?> 
    </div>

    <div class="clear-both"></div>
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  atti in evidenza
<?php end_slot() ?>
