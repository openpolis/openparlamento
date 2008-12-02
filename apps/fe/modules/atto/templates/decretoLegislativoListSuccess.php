<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <?php include_partial('decretoLegislativoRightColumn') ?>    
	</div>
    <div class="W73_100 float-left">
      <?php include_partial('decretoLegislativoWiki') ?>

      <?php include_partial('decretoLegislativoFilter') ?>	

      <?php include_partial('decretoLegislativoSort') ?>

      <?php include_partial('decretoLegislativoList', array('pager' => $pager)) ?>  
    </div>
    <div class="clear-both"></div>
  </div>
</div>