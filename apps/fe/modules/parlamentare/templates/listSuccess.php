<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <?php include_partial('parlamentareRightColumn') ?>     
    </div>
    <div class="W73_100 float-left">	
      <?php include_partial('wiki') ?>       
    
      <?php include_partial('filter') ?> 

      <?php include_partial('sort') ?>   
    </div>
	<div class="W100_100 float-left"> 
	  <?php include_partial('list', array('parlamentari' => $parlamentari, 'numero_parlamentari' => $numero_parlamentari)) ?>  
    </div>
    <div class="clear-both"></div>
  </div>
</div>
