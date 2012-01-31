<ul id="content-tabs" class="float-container tools-container"> 
  <li class="current">
    <h2>
      Chi siamo
    </h2>
  </li>
</ul>

<div class="row">
	<div class="ninecol">
		<div style="font-size:14px; padding:5px; line-height:1,5em;"> 
		<p><em class="open">open</em><em class="parlamento">parlamento</em> &egrave; un'iniziativa del progetto <?php echo link_to('openpolis','http://www.openpolis.it') ?> gestito dall'associazione omonima che &egrave; indipendente, apartitica, aconfessionale e senza scopo di lucro.</p>
		<p>&nbsp;</p>
		<p>La sostenibilit&agrave; del progetto - con tutte le sue articolazioni - viene perseguita attraverso il contributo dei soci.<br />
		<strong>Promuovi la trasparenza e la partecipazione: <?php echo link_to('diventa anche tu socio di openpolis!','http://associazione.openpolis.it/contribuisci/diventa-socio') ?></strong></p>
		<p>&nbsp;</p>
		La vendita di alcuni servizi commerciali sono gestiti da una societ&agrave; apposita, la <?php echo link_to('depp srl','http://www.depp.it') ?>. 
		<p>&nbsp;</p>
		<p><em class="open">open</em><em class="parlamento">parlamento</em> &egrave; stato realizzato in collaborazione tra la <?php echo link_to('depp srl','http://www.depp.it') ?> e la <?php echo link_to('smaug/memefarmers','http://www.memefarmers.net') ?>.</p>
		<p>Alla sua realizzazione hanno lavorato: Vittorio Alvino, Gianluca Canale, Guglielmo Celata, Alessandro Curci, Ettore Di Cesare, Renato Minei, Salvatore Santalucia e Vincenzo Smaldore.</p>
		<p>&nbsp;</p>
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
  chi siamo
<?php end_slot() ?>