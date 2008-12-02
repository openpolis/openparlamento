<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right"></div>
    <div class="W73_100 float-left">
      <?php include_partial('decretoWiki') ?>  		

      <?php include_partial('decretoFilter') ?>

      <?php include_partial('decretoSort') ?>
     
      <?php include_partial('decretoList', array('pager' => $pager)) ?> 
    </div>
    <div class="clear-both"></div>
  </div>
</div>