<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right">
      <?php include_partial('attoNonLegislativoRightColumn') ?>   
	</div>
    <div class="W73_100 float-left">
      <?php include_partial('attoNonLegislativoWiki') ?>  	  		

      <?php include_partial('attoNonLegislativoFilter') ?>

      <?php include_partial('attoNonLegislativoSort') ?>

      <?php include_partial('attoNonLegislativoList', array('pager' => $pager)) ?>
    </div>
    <div class="clear-both"></div>
  </div>
</div>