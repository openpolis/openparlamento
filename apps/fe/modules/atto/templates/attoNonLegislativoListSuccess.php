<?php use_helper('I18N', 'Date') ?>

<ul id="content-tabs" class="float-container tools-container">
  <li class="current"><h2>Atti non legislativi</h2></li>
</ul>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W25_100 float-right"></div>
    <div class="W73_100 float-left">
      <?php include_partial('attoNonLegislativoWiki') ?>  	  		

      <?php include_partial('attoNonLegislativoFilter') ?>

      <?php include_partial('attoNonLegislativoSort') ?>

      <?php include_partial('attoNonLegislativoList', array('pager' => $pager)) ?>
    </div>
    <div class="clear-both"></div>
  </div>
</div>