<?php use_helper('Date') ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2>On.<?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
		<div class="W25_100 float-right">
			<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>
			<div id="monitor-n-vote">
				<h6>monitora questo politico</h6>
				<!-- usare la classe "start-monitoring" o "stop-monitoring" secondo lo stato di monitoraggio -->
				<h6 class="start-monitoring"><a href="#">avvia il monitoraggio per questo politico</a></h6>

				<p><a href="#">765</a> utenti monitorano questo politico</p>
				<p class="open-next-div"><a class="action" href="#">questi utenti monitorano anche...</a></p>		
					
				<div style="display: none;" class="monitoring-also">
					<hr class="dotted"/>			
											
					<h5 class="subsection-spec">...i politici:</h5>
								
					<div class="topics float-container">
						<a href="#">Veltroni (33)</a>
						<a href="#">Alemanno (11)</a>
						<a href="#">Carfagna (99)</a>
						<a href="#">Valentini (3)</a>
						<a href="#">Pistorio (5)</a>
					</div>		
						
					<h5 class="subsection-spec">...i DDL:</h5>				
						
					<div class="topics float-container">
						<a href="#"><em>C.1386-B</em> (33)</a>
						<a href="#"><em>C.986-5</em> (44)</a>
						<a href="#"><em>S.86-C</em> (55)</a>
						<a href="#"><em>C.1386-B</em> (33)</a>
						<a href="#"><em>C.986-5</em> (44)</a>
						<a href="#"><em>S.86-C</em> (55)</a>
						<a href="#"><em>C.1386-B</em> (33)</a>
						<a href="#"><em>C.986-5</em> (44)</a>
						<a href="#"><em>S.86-C</em> (55)</a>
					</div>						
							
					<hr class="dotted"/>
					<div class="more-results-close close-parent-div">[ <a href="#" class="btn-close action">chiudi</a> ]</div>
				</div>

			</div>
				
		</div>
			
	  <div class="W73_100 float-left">
	    <?php echo include_partial('secondlevelmenu', array('current' => 'cosa')); ?>
	
  		<p class="tools-container"><a class="ico-help" href="#">eventuale testo micro-help</a></p>
  		<div style="display: none;" class="help-box float-container">
  			<div class="inner float-container">
	
  				<a class="ico-close" href="#">chiudi</a><h5>eventuale testo micro-help ?</h5>
  				<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  			</div>
  		</div>

  		<div class="W25_100 float-right">
  		  <?php echo link_to('la sua pagina su ' . image_tag('/images/logo-openpolis.png', 
  		                                                    array('alt' => 'openpolis')), 
  		                     'http://www.openpolis.it/politico/'.$parlamentare->getId(),
  		                     array('class' => 'jump-to-openpolis')) ?>
        
  			<a class="jump-to-camera" href="#">vai alla scheda su <img alt="camera dei deputati" src="/images/logo-camera-deputati.png"/></a>
			
  			<div class="evidence-box float-container">
  				<h5 class="subsection">Si occupa di...</h5>
  				<p class="pad10">
  					<a class="folk1" href="#">Cooperazione</a>,
  					<a class="folk4" href="#">aborto</a>,
  					<a class="folk2" href="#">armi</a>,
  					<a class="folk5" href="#">Abruzzo</a>,
  					<a class="folk5" href="#">immigrazione</a>,
  					<a class="folk5" href="#">riforme istituzionali</a>,
  					<a class="folk5" href="#">rifiuti</a>,
  					<a class="folk5" href="#">bilancio partecipato</a>
  				</p>
  			</div>		

  			<div class="evidence-box float-container">
  				<h5 class="subsection">Vota più spesso come...</h5>
  				<div class="pad10">
  					<p class="green">parlamentari del suo gruppo:</p>
  					<p>
  						<a class="folk5" href="#">Silvio BERLUSCONI</a>,
  						<a class="folk5" href="#">Fabrizio CICCHETTO</a>,
  						<a class="folk5" href="#">Giovanni Battista BACHELET</a>
  					</p>
  					<p class="violet">parlamentari di altri gruppi:</p>
  					<p>
  						<a class="folk5" href="#">Silvio BERLUSCONI (PdL)</a>,
  						<a class="folk5" href="#">Fabrizio CICCHETTO (PD)</a>,
  						<a class="folk5" href="#">Giovanni Battista BACHELET (PD)</a>
  					</p>					
  				</div>
  			</div>		

  			<div class="evidence-box float-container">
  				<h5 class="subsection">Firma atti più spesso come...</h5>
  				<div class="pad10">
  					<p class="green">parlamentari del suo gruppo:</p>
  					<p>
  						<a class="folk5" href="#">Silvio BERLUSCONI</a>,
  						<a class="folk5" href="#">Fabrizio CICCHETTO</a>,
  						<a class="folk5" href="#">Giovanni Battista BACHELET</a>
  					</p>
  					<p class="violet">parlamentari di altri gruppi:</p>
  					<p>
  						<a class="folk5" href="#">Silvio BERLUSCONI (PdL)</a>,
  						<a class="folk5" href="#">Fabrizio CICCHETTO (PD)</a>,
  						<a class="folk5" href="#">Giovanni Battista BACHELET (PD)</a>
  					</p>					
  				</div>
  			</div>				
  		</div>
		
  		<div class="W73_100 float-left">
  			<div class="float-container">
  			  <?php echo image_tag("http://www.openpolis.it/politician/picture?content_id=".$parlamentare->getId(),
  			                       array('class' => 'portrait-91x126 float-left', 
  			                             'alt' => $parlamentare->getNome() . ' ' . $parlamentare->getCognome(),
  			                             'width' => '91', 'height' => '126')) ?>
  				<div class="politician-more-info">
  					<p><label>gruppo:</label> 
					     <?php echo link_to($acronimo_gruppo_corrente, 
					                        '@parlamentari?ramo='.$ramo.'&filter_group='.$id_gruppo_corrente) ?>
  					  <?php if (count($gruppi) > 1): ?>
  					   (
  					  <?php endif ?>
  					  <?php foreach ($gruppi as $acronimo => $gruppo): ?>
  					   <?php if ($acronimo != $acronimo_gruppo_corrente): ?>
  					     dal <?php echo $gruppo['data_inizio'] ?>
  					     al <?php echo $gruppo['data_fine'] ?>:
  					     <?php echo link_to($acronimo, 
  					                        '@parlamentari?ramo='.$ramo.'&filter_group='.$gruppo['gruppo_id']) ?>
  					   <?php endif ?>
  					  <?php endforeach ?>
  					  <?php if (count($gruppi) > 1): ?>
  					   )
  					  <?php endif ?>
  					</p>
  					<p><label>circoscrizione:</label> 
  					  <?php echo link_to($circoscrizione, '@parlamentari?ramo='.$ramo.'&filter_const='.$circoscrizione) ?>
  					</p>
  					<p><label>dal:</label> <strong>dd/mm/yyyy</strong> <label>al:</label> <strong>dd/mm/yyyy</strong><br/> 
  					<strong>CARICA PRECEDENTE O CONTEMPORANEA A QUELLA ATTUALE</strong></p>
  				</div>
  			</div>
		 
  			<h5 class="subsection-alt">Presenze in <?php echo $nvotazioni ?> votazione elettroniche</h5>
  			<p class="float-right">ultima votazione: <strong>gg-mm-aaaa</strong></p>
  			<p class="tools-container"><a class="ico-help" href="#">come sono calcolate</a></p>
  			<div style="display: none;" class="help-box float-container">
  				<div class="inner float-container">		
  					<a class="ico-close" href="#">chiudi</a><h5>come sono calcolate ?</h5>
  					<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  				</div>
  			</div>
			
  			<!-- usare &nbsp; invece dello spazio, e' importante per il layout  !!  -->
  			<div class="meter-bar float-container">
  				<label>presenze:</label>
  				<div class="green-meter-bar">
  					<div style="left: <?php echo $presenze_media_perc ?>%;" class="meter-average"><label>valore medio: <?php echo $presenze_media_perc ?> (<?php echo $presenze_media ?>)</label> </div>
  					<div style="width: <?php echo $presenze_perc ?>%;" class="meter-label"><?php echo $presenze_perc ?>% (<?php echo $presenze ?>)</div>									
  					<div style="width: <?php echo $presenze_perc ?>%;" class="meter-value"> </div>
  				</div>
  				<label>assenze:</label>
  				<div class="red-meter-bar">
  					<div style="left: <?php echo $assenze_media_perc ?>%;" class="meter-average"><label>valore medio: <?php echo $assenze_media_perc ?>% (<?php echo $assenze_media ?>)</label> </div>
  					<div style="width: <?php echo $assenze_perc ?>%;" class="meter-label"><?php echo $assenze_perc ?>% (<?php echo $assenze ?>)</div>									
  					<div style="width: <?php echo $assenze_perc ?>%;" class="meter-value"> </div>
  				</div>
  				<label>missioni:</label>
  				<div class="blue-meter-bar">
  					<div style="left: <?php echo $missioni_media_perc ?>%;" class="meter-average"><label>valore medio: <?php echo $missioni_media_perc ?>% (<?php echo $missioni_media ?>)</label> </div>
  					<div style="width: <?php echo $missioni_perc ?>%;" class="meter-label"><?php echo $missioni_perc ?>% (<?php echo $missioni ?>)</div>									
  					<div style="width: <?php echo $missioni_perc ?>%;" class="meter-value"> </div>
  				</div>
  				<p class="float-right">
  				  <?php echo link_to('vai alla classifica', 
  				                     '@parlamentari?ramo=' . $ramo .
  				                      '&sort=presenze&type=desc') ?>
  				</p>
  			</div>
		 
  			<h5 class="subsection-alt">Voti ribelli su <?php echo $nvotazioni ?> votazioni elettroniche</h5>
			
  			<p class="tools-container"><a class="ico-help" href="#">come viene calcolato</a></p>
  			<div style="display: none;" class="help-box float-container">
  				<div class="inner float-container">		
  					<a class="ico-close" href="#">chiudi</a><h5>come viene calcolato ?</h5>
  					<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  				</div>
  			</div>
			
  			<div class="meter-bar float-container">
  				<label>voti ribelli:</label>
  				<div class="violet-meter-bar">
  					<div style="left: <?php echo $ribelli_media_perc ?>%;" class="meter-average"><label>valore medio: <?php echo $ribelli_media_perc ?>% (<?php echo $ribelli_media ?>)</label> </div>
  					<div style="width: <?php echo $ribelli_perc ?>%;" class="meter-label"><?php echo $ribelli_perc ?>% (<?php echo $ribelli ?>)</div>									
  					<div style="width: <?php echo $ribelli_set ?>%;" class="meter-value"> </div>
  				</div>
  				<div class="evidence-box">
  				  <?php foreach ($gruppi as $acronimo => $gruppo): ?>
    					<label>nel gruppo <?php echo $acronimo ?>:</label><div class="violet-meter-bar"><div style="width: <?php echo number_format(100*$gruppo['ribelle']/$gruppo['presenze'], 2) ?>%;" class="meter-value"><?php echo number_format(100*$gruppo['ribelle']/$gruppo['presenze'], 2) ?>% (<?php echo $gruppo['ribelle'] ?> su <?php echo $gruppo['presenze'] ?> votazioni)</div></div>  				    
  				  <?php endforeach ?>
  				</div>
  				<p class="float-right">
  				  <?php echo link_to('vai alla classifica', 
  				                     '@parlamentari?ramo=' . $ramo .
  				                      '&sort=ribelle&type=desc') ?>
  				</p>
  			</div>

  			<h5 class="subsection-alt">Indice di attività</h5>

  			<p class="tools-container"><a class="ico-help" href="#">come viene calcolato</a></p>
  			<div style="display: none;" class="help-box float-container">
  				<div class="inner float-container">		
  					<a class="ico-close" href="#">chiudi</a><h5>come viene calcolato ?</h5>
  					<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  				</div>
  			</div>

  			<div class="meter-bar float-container">
  				<label class="mb-idx-label">indice:</label>
  				<div class="mb-idx">
  					<ul class="t<?php echo number_format($carica->getIndice(), 0) ?>"> <!-- usare class t0, t1 ... t9, t10 - esempio: indice = "3.14", classe = "t3" ... usare Math.floor -->
  						<li class="i1"><p><sup>1</sup>|</p></li>
  						<li class="i2"><p><sup>2</sup>|</p></li>
  						<li class="i3"><p><sup>3</sup>|</p></li>
  						<li class="i4"><p><sup>4</sup>|</p></li>
  						<li class="i5"><p><sup>5</sup>|</p></li>
  						<li class="i6"><p><sup>6</sup>|</p></li>
  						<li class="i7"><p><sup>7</sup>|</p></li>
  						<li class="i8"><p><sup>8</sup>|</p></li>
  						<li class="i9"><p><sup>9</sup>|</p></li>
  						<li class="i10"><p><sup>10</sup>|</p></li>
  					</ul>
  					<div style="left: <?php echo 10*$carica->getMedia() ?>%;" class="meter-average"><label>media deputati: <?php echo $carica->getMedia() ?></label> </div>
  					<div style="left: <?php echo 10*$carica->getIndice() ?>%;" class="meter-label"><?php echo number_format($carica->getIndice(), 2) ?></div>
  				</div>
  			</div>
  			<div class="meter-bar float-container">
  				<label class="mb-idx-label">classifica:</label>
  				<div class="pos-idx"><strong><?php echo $carica->getPosizione() ?></strong> su 630 deputati</div>
  				<p class="float-right">
  				  <?php echo link_to('vai alla classifica', 
  				                     '@parlamentari?ramo=' . $ramo .
  				                      '&sort=indice&type=desc') ?>
  				</p>
  			</div>



		 
  		</div>
	  </div>


    <div class="W100_100 float-left">
    	<h5 class="subsection">Cosa fa? (le 167 notizie relative alle attività del parlamentare)</h5>			
    	<p class="tools-container"><a class="ico-help" href="#">come viene calcolato</a></p>
    	<div style="display: none;" class="help-box float-container">
    		<div class="inner float-container">
    			<a class="ico-close" href="#">chiudi</a><h5>come viene calcolato ?</h5>
    			<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
    		</div>
    	</div>
				
    	<form action="#" class="float-container" id="disegni-decreti-filter">
    		<fieldset class="labels">
    			<label for="topic">argomento:</label>
    			<label for="type">iniziativa:</label>
    			<label for="room">ramo:</label>
    		</fieldset>	
    		<p>
    		filtra per
    		</p>	
    		<fieldset class="combobox-group">			
    			<div style="padding: 0pt; width: 130px;" class="comboboxContainer" tabindex="0"><select name="topic" id="topic" style="display: none;">
    				<option selected="selected" value="0">tutti</option>
    				<option value="1">1. lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</option>
    				<option value="2">2. lorem ipsum</option>
    			</select><div style="overflow: hidden; position: relative; background-position: 0px 0px; width: 130px; height: 23px;" class="comboboxValueContainer"><div style="overflow: hidden; float: left; position: absolute; cursor: default; width: 97px; height: auto; top: 5.5px;" class="comboboxValueContent" title="tutti">tutti</div><div style="background-repeat: no-repeat; float: right;" class="comboboxDropDownButton"/></div><ul style="margin: 0pt; overflow: auto; list-style-type: none; min-height: 15px; padding-top: 0pt; position: absolute; z-index: 20000; width: 322px; left: 76px; display: none;" class="comboboxDropDownContainer" tabindex="0"><li class="comboboxItem comboboxItemHover" style="display: block;" title="tutti">tutti</li><li class="comboboxItem" style="display: block;" title="1. lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum">1. lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</li><li class="comboboxItem" style="display: block;" title="2. lorem ipsum">2. lorem ipsum</li></ul></div>
    			<div style="padding: 0pt; width: 130px;" class="comboboxContainer" tabindex="0"><select name="type" id="type" style="display: none;">
    				<option selected="selected" value="0">tutte</option>
    				<option value="1">1. lorem ipsum</option>
    				<option value="2">2. lorem ipsum</option>
    			</select><div style="overflow: hidden; position: relative; background-position: 0px 0px; width: 130px; height: 23px;" class="comboboxValueContainer"><div style="overflow: hidden; float: left; position: absolute; cursor: default; width: 97px; height: auto; top: 5.5px;" class="comboboxValueContent" title="tutte">tutte</div><div style="background-repeat: no-repeat; float: right;" class="comboboxDropDownButton"/></div><ul style="margin: 0pt; overflow: auto; list-style-type: none; min-height: 15px; padding-top: 0pt; position: absolute; z-index: 20000; width: 130px; left: 213px; display: none;" class="comboboxDropDownContainer" tabindex="0"><li class="comboboxItem comboboxItemHover" style="display: block;" title="tutte">tutte</li><li class="comboboxItem" style="display: block;" title="1. lorem ipsum">1. lorem ipsum</li><li class="comboboxItem" style="display: block;" title="2. lorem ipsum">2. lorem ipsum</li></ul></div>
    			<div style="padding: 0pt; width: 130px;" class="comboboxContainer" tabindex="0"><select name="room" id="room" style="display: none;">
    				<option selected="selected" value="0">tutti</option>
    				<option value="1">1. lorem ipsum</option>
    				<option value="2">2. lorem ipsum</option>
    			</select><div style="overflow: hidden; position: relative; background-position: 0px 0px; width: 130px; height: 23px;" class="comboboxValueContainer"><div style="overflow: hidden; float: left; position: absolute; cursor: default; width: 97px; height: auto; top: 5.5px;" class="comboboxValueContent" title="tutti">tutti</div><div style="background-repeat: no-repeat; float: right;" class="comboboxDropDownButton"/></div><ul style="margin: 0pt; overflow: auto; list-style-type: none; min-height: 15px; padding-top: 0pt; position: absolute; z-index: 20000; width: 130px; left: 350px; display: none;" class="comboboxDropDownContainer" tabindex="0"><li class="comboboxItem comboboxItemHover" style="display: block;" title="tutti">tutti</li><li class="comboboxItem" style="display: block;" title="1. lorem ipsum">1. lorem ipsum</li><li class="comboboxItem" style="display: block;" title="2. lorem ipsum">2. lorem ipsum</li></ul></div>
    			<input type="image" style="display: none;" alt="applica" src="/images/btn-applica.png" name="disegni-decreti-filter-apply" id="disegni-decreti-filter-apply"/>
    		</fieldset>
    	</form>
	
    	<form action="#" id="disegni-decreti-time-filter">
    	<p>mostra notizie</p>
    	<fieldset>
    		<label for="startDate">dal</label><input type="text" maxlength="10" size="10" class="input-text hasDatepicker" name="startDate" id="startDate"/><img class="ui-datepicker-trigger" src="/images/ico-calendar.png" alt="..." title="..."/> 
    		<label for="endDate">al</label><input type="text" maxlength="10" size="10" class="input-text hasDatepicker" name="endDate" id="endDate"/><img class="ui-datepicker-trigger" src="/images/ico-calendar.png" alt="..." title="..."/> 
    	</fieldset>
    	</form>
	
    </div>

    <div class="W100_100 float-left">

    	<div class="more-results float-container">			
    		<ul class="square-bullet">
    			<li><em>23-06-2008</em><br/><a href="#">Ille inviar disuso da del, malo russo flexione qui da.</a></li>
    			<li><em>23-06-2008</em><br/><a href="#">E sed toto commun pardona, europee philologos interlingua ha duo, tote prime dictionario pro un.</a></li>
    			<li><em>23-06-2008</em><br/><a href="#">Effortio language supervivite ha que, programma independente al pro.</a></li>
    			<li><em>23-06-2008</em><br/><a href="#">In que facite preparation, uso le texto hereditage introduction, usate nomine vocabulos su per.</a></li>
    			<li><em>23-06-2008</em><br/><a href="#">Nos deler altere studio da, il africa subjecto incorporate sed, le pro iste nomina conferentias.</a></li>
    			<li><em>23-06-2008</em><br/><a href="#">Pro da vista summarios professional, da via malo titulo americas. O per commun linguas instruction.</a></li>
    		</ul>
    	</div>
	
    	<p class="float-right"><strong><a href="#">vedi tutte le altre 1234 notizie</a></strong></p>
	
    </div>			

    <div class="clear-both"/>			
    </div>
		
  </div>
</div>

<!-- partial per la gestione del monitoring di questo politico -->
<?php echo include_component('monitoring', 'manageItem', 
                             array('item' => $parlamentare, 'item_type' => 'politico')); ?>
