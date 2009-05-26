<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Chi siamo
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container">

  <div id="main"> 
   <div class="W25_100 float-right"> 
    <div style="font-size:14px; background-color:#efefef; padding:5px"><span style="padding:0 10px 0 0; "><?php echo image_tag('/images/start_quote_rb.gif') ?></span><i>Io sono per la cooperazione, per la distribuzione del lavoro, per permettere a tutti di giocare.</i><span style="padding:20px; "><?php echo image_tag('/images/end_quote_rb.gif',array('alt'=>'fine citazione')) ?></span>
     <p style="text-align:right; font-size:12px;"><?php echo link_to('Renzo Ulivieri','http://it.wikipedia.org/wiki/Renzo_Ulivieri') ?></p>
    </div> 
  </div>
    <div class="W73_100 float-left">
  
Testo di chi siamo
    </div>
  </div>

</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  chi siamo
<?php end_slot() ?>