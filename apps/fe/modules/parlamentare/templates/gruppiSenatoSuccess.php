<?php include_partial('tabs',array('ramo'=>2,'gruppi'=>true)) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W73_100 float-left">	
      <?php //include_partial('wikiGruppi') ?>       
    </div>
    
<div class="W73_100 float-left">
<?php echo include_component('parlamentare','gruppiParlamentari',array('ramo' => 2, 'leg'=> 16)) ?>
</div>

  </div>
</div>