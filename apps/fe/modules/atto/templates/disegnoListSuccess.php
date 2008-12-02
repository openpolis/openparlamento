<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right"></div>
    <div class="W73_100 float-left">
      <?php include_partial('disegnoWiki') ?>      		

      <?php include_partial('disegnoFilter') ?>

      <?php include_partial('disegnoSort') ?>
     
      <?php include_partial('disegnoList', array('pager' => $pager)) ?>
	</div>
    <div class="clear-both"></div>
  </div>
</div>