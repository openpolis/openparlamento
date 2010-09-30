<?php include_partial('tabs',array('ramo'=>1,'gruppi'=>true)) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W73_100 float-left">	
      <?php //include_partial('wikiGruppi') ?>       
    </div>
    
<div class="W73_100 float-left" style="width:63%">
<?php echo include_component('parlamentare','gruppiParlamentari',array('ramo' => 1, 'leg'=> 16)) ?>
</div>

  </div>
</div>  

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
    gruppi della camera
<?php end_slot() ?>