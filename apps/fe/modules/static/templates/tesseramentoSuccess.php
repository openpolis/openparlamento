<div class="row" id="tabs-container">
    <ul id="content-tabs" class="float-container tools-container"> 
      <li class="current">
        <h2>
          Sostieni Openpolis!
        </h2>
      </li>
    </ul>
</div>

<div class="row">
	<div class="ninecol">
		
		<div style="font-size:14px; padding:5px; line-height:1,5em;"> 
		<p><em class="open">open</em><em class="parlamento">parlamento</em> &egrave; un'iniziativa del progetto <?php echo link_to('openpolis','https://www.openpolis.it') ?> gestito dall'associazione omonima che &egrave; indipendente, apartitica, aconfessionale e senza scopo di lucro.</p>
		<p>&nbsp;</p>
		
		<p style="font-size:18px; padding-top:5px;">Contribuisci a sostenere openpolis, openparlamento e tutte le nuove iniziative.<br/><br/>
		  <a href="https://www.openpolis.it/sostienici/dona/"><strong>Dona ad Openpolis</strong></a><br/><br/>
		  <a href="https://www.openpolis.it/5xmille/"><strong>Il tuo 5xmille a Openpolis</strong></a>
	  </p>
		</div>
		
	</div>
	<div class="threecol last">
		
		<div style="font-size:14px; background-color:#efefef; padding:5px"><span style="padding:0 10px 0 0; "><?php echo image_tag('/images/start_quote_rb.gif') ?></span><i>Io sono per la cooperazione, per la distribuzione del lavoro, per permettere a tutti di giocare.</i><span style="padding:20px; "><?php echo image_tag('/images/end_quote_rb.gif',array('alt'=>'fine citazione')) ?></span>
	     <p style="text-align:right; font-size:12px;"><?php echo link_to('Renzo Ulivieri','http://it.wikipedia.org/wiki/Renzo_Ulivieri') ?></p>
	    </div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  diventa socio di openpolis
<?php end_slot() ?>
