<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Contatti
    </h2>
  </li>
</ul>

<div class="row">
	<div class="ninecol">
		
		<div style="font-size:16px; padding:5px; line-height:1,5em;">
	    <p><em class="open"><strong>Per contatti sulla gestione del progetto:</strong></em> </p>
	    <p>associazione <?php echo link_to('openpolis','http://www.openpolis.it') ?>, via dei sabelli 215 00185 roma - tel: +39 06.83608392 - e-mail: info [chiocciola] openpolis [punto] it</p>
	    <p>&nbsp;</p>
	    <p><em class="open"><strong>Per informazioni sui servizi commerciali:</strong></em> </p>
	    <p><?php echo link_to('depp srl','http://www.depp.it') ?>, tel: +39 348.2506004 - fax: +39 1786073852 - e-mail: info [chiocciola] depp [punto] it</p>
	    <p>&nbsp;</p>
	    </div>
		
	</div>
	<div class="threecol last"></div>
</div>


<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  contatti
<?php end_slot() ?>