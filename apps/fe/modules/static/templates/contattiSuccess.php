<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Contatti
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container">

  <div id="main"> 
   
    <div class="W73_100 float-left">
    <div style="font-size:16px; padding:5px; line-height:1,5em;">
    <p><em class="open"><strong>Per contatti sulla gestione del progetto:</strong></em> </p>
    <p>associazione <?php echo link_to('openpolis','http://www.openpolis.it') ?>, via luigi montuori 5 00154 roma - e-mail:info@openpolis.it</p>
    <p>&nbsp;</p>
    <p><em class="open"><strong>Per informazioni sui servizi commerciali:</strong></em> </p>
    <p><?php echo link_to('depp srl','http://www.depp.it') ?>, e-mail: info@depp.it - tel: +39 348.2506004 - fax: +39 06.5123457</p>
    <p>&nbsp;</p>
    </div>
    </div>
  </div>

</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  contatti
<?php end_slot() ?>