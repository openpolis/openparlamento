<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      <?php echo "Le classifiche" ?>  
    </h2>
  </li>
</ul>


  <div id="content" class="tabbed float-container">
   <div id="main">
   <div style="padding:5px;"> 
   
   </div>
   
   <div class="W48_100 float-right">
   <h1 class="redbox">i senatori</h1>
    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'1','limit'=>'3')); ?>
    <hr class="redbox" />
    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'2','limit'=>'3')); ?>
    <hr class="redbox" />
    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'3','limit'=>'3')); ?>
    <hr class="redbox" />
    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'5','limit'=>'3')); ?>
    <hr class="redbox" />
    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'4','limit'=>'3')); ?>
 
   
   </div>
   
    <div class="W48_100 float-left">
    <h1 class="bluebox">i deputati</h1>
    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'1','limit'=>'3')); ?>
     <hr class="bluebox" />
    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'2','limit'=>'3')); ?>
     <hr class="bluebox" />
    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'3','limit'=>'3')); ?>
     <hr class="bluebox" />
    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'5','limit'=>'3')); ?>
     <hr class="bluebox" />
    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'4','limit'=>'3')); ?>
    
   </div>
   
   
   
   </div>
  </div> 
  
  <?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
    le classifiche  
<?php end_slot() ?>