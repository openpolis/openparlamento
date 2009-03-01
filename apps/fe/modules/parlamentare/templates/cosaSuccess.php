<?php use_helper('Date', 'Number') ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2><?php echo $ramo=='camera' ? 'On. ' : 'Sen. ' ?><?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
		<div class="W25_100 float-right">
			<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>

			<div id="monitor-n-vote">
      	<h6>monitora questo politico</h6>

        <!-- partial per la gestione del monitoring di questo politico -->
        <?php echo include_component('monitoring', 'manageItem', 
                                     array('item' => $parlamentare, 'item_type' => 'politico')); ?>



        <?php echo include_component('parlamentare', 'monitoringalso', array('item' => $parlamentare)); ?>

  		</div>
      
      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Disegni di legge', 
                                       'all_news_url' => '@news_attiDisegni', 
                                       'news'   => NewsPeer::getAttiListNews(NewsPeer::ATTI_DDL_TIPO_IDS, 10))); ?>
    </div>
			
	  <div class="W73_100 float-left">
	    <?php echo include_partial('secondlevelmenu', 
	                               array('current' => 'cosa', 
	                                     'parlamentare_id' => $parlamentare->getId())); ?>
	                                     	
  		<p class="tools-container"><a class="ico-help" href="#">eventuale testo micro-help</a></p>
  		<div style="display: none;" class="help-box float-container">
  			<div class="inner float-container">
	
  				<a class="ico-close" href="#">chiudi</a><h5>eventuale testo micro-help ?</h5>
  				<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  			</div>
  		</div>

  		<div class="W25_100 float-right" style="width:37%">
  		  <?php echo link_to('la sua pagina su ' . image_tag('/images/logo-openpolis.png', 
  		                                                    array('alt' => 'openpolis')), 
  		                     'http://www.openpolis.it/politico/'.$parlamentare->getId(),
  		                     array('class' => 'jump-to-openpolis')) ?>
  		                     
                  <?php if ($ramo=='camera') : ?> 
                     <?php $url='http://www.camera.it/cartellecomuni/leg16/include/contenitore_dati.asp?tipopagina=&deputato=d'.$carica->getParliamentId().'&source=%2Fdeputatism%2F240%2Fdocumentoxml.asp&position=Deputati\La%20Scheda%20Personale&Pagina=Deputati/Composizione/SchedeDeputati/SchedeDeputati.asp%3Fdeputato=d'.$carica->getParliamentId() ?> 
                     <?php echo link_to('la sua pagina su ' . image_tag('/images/logo-camera-deputati.png', 
  		                                                    array('alt' => 'vai al sito della camera dei deputati')), 
  		                                                    $url,
  		                                                    array('class' => 'jump-to-camera')) ?>   
                  <?php else : ?>
                     <?php $url='http://www.senato.it/loc/link.asp?tipodoc=sattsen&leg=16&id='.$carica->getParliamentId() ?>
                     <?php echo link_to('la sua pagina su ' . image_tag('/images/logo-senato.png', 
  		                                                    array('alt' => 'vai al sito del senato')), 
  		                                                    $url,
  		                                                    array('class' => 'jump-to-camera')) ?>   
                  <?php endif ?> 
                   
			
        <?php echo include_component('parlamentare', 'sioccupadi', array('carica' => $carica)); ?>

        <?php if ($nvoti_validi>0): ?>
          <?php echo include_component('parlamentare', 'votacome', 
                                       array('carica' => $carica, 
                                             'acronimo' => $acronimo_gruppo_corrente)); ?>          
        <?php endif ?>

        <?php echo include_component('parlamentare', 'firmacon', 
                                     array('carica' => $carica,
                                           'acronimo' => $acronimo_gruppo_corrente)); ?>

  		</div>
		
  		<div class="W73_100 float-left" style="width:60%">
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
  					 <?php if ($circoscrizione=="") : ?>
  					   <p><label>Senatore a vita</label></p>  
  					 <?php else : ?>
  					   <p><label>circoscrizione:</label> 
  					      <?php echo link_to($circoscrizione, '@parlamentari?ramo='.$ramo.'&filter_const='.$circoscrizione) ?>
  					    </p>
  					 <?php endif ?> 
  					  
  					<p><label>dal:</label> <strong>dd/mm/yyyy</strong> <label>al:</label> <strong>dd/mm/yyyy</strong><br/> 
  					<strong>CARICA PRECEDENTE O CONTEMPORANEA A QUELLA ATTUALE</strong></p>
  				</div>
  			</div>
		 
  			<h5 class="subsection-alt">Presenze in <?php echo $nvotazioni ?> votazioni elettroniche</h5>
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
  					<div style="left: <?php echo number_format($presenze_media_perc, 2) ?>%;" class="meter-average"><label>valore medio: <?php echo number_format($presenze_media_perc, 2) ?> (<?php echo number_format($presenze_media, 0) ?>)</label> </div>
  					<div style="width: <?php echo number_format($presenze_perc, 2) ?>%;" class="meter-label"><?php echo number_format($presenze_perc, 2) ?>% (<?php echo number_format($presenze, 0) ?>)</div>									
  					<div style="width: <?php echo number_format($presenze_perc, 2) ?>%;" class="meter-value"> </div>
  				</div>
  				<label>assenze:</label>
  				<div class="red-meter-bar">
  					<div style="left: <?php echo number_format($assenze_media_perc, 2) ?>%;" class="meter-average"><label>valore medio: <?php echo number_format($assenze_media_perc,2) ?>% (<?php echo number_format($assenze_media,0) ?>)</label> </div>
  					<div style="width: <?php echo number_format($assenze_perc,2) ?>%;" class="meter-label"><?php echo number_format($assenze_perc, 2) ?>% (<?php echo number_format($assenze, 0) ?>)</div>									
  					<div style="width: <?php echo number_format($assenze_perc, 2) ?>%;" class="meter-value"> </div>
  				</div>
  				<label>missioni:</label>
  				<div class="blue-meter-bar">
  					<div style="left: <?php echo number_format($missioni_media_perc, 2) ?>%;" class="meter-average"><label>valore medio: <?php echo number_format($missioni_media_perc, 2) ?>% (<?php echo number_format($missioni_media, 0) ?>)</label> </div>
  					<div style="width: <?php echo number_format($missioni_perc, 2) ?>%;" class="meter-label"><?php echo number_format($missioni_perc, 2) ?>% (<?php echo number_format($missioni, 0) ?>)</div>									
  					<div style="width: <?php echo $missioni_perc ?>%;" class="meter-value"> </div>
  				</div>
  				<p class="float-right">
  				  <?php echo link_to('vai alla classifica', 
  				                     '@parlamentari?ramo=' . $ramo .
  				                      '&sort=presenze&type=desc') ?>
  				</p>
  			</div>
		 
  			<h5 class="subsection-alt">Voti ribelli su <?php echo $nvoti_validi ?> votazioni nominali</h5>
			
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
  					<div style="left: <?php echo number_format($ribelli_media_perc, 2) ?>%;" class="meter-average"><label>valore medio: <?php echo number_format($ribelli_media_perc, 2) ?>% (<?php echo number_format($ribelli_media, 0) ?>)</label> </div>
  					<div style="width: <?php echo number_format($ribelli_perc, 2) ?>%;" class="meter-label"><?php echo number_format($ribelli_perc, 2) ?>% (<?php echo number_format($ribelli, 0) ?>)</div>									
  					<div style="width: <?php echo number_format($ribelli_perc, 2) ?>%;" class="meter-value"> </div>
  				</div>
  				<?php if (count($gruppi) > 1): ?>
    				<div class="evidence-box">
    				  <?php foreach ($gruppi as $acronimo => $gruppo): ?>
      					<label>nel gruppo <?php echo $acronimo ?>:</label><div class="violet-meter-bar"><div style="width: <?php echo number_format(100*$gruppo['ribelle']/$gruppo['presenze'], 2) ?>%;" class="meter-value"><?php echo number_format(100*$gruppo['ribelle']/$gruppo['presenze'], 2) ?>% (<?php echo $gruppo['ribelle'] ?> su <?php echo $gruppo['presenze'] ?> votazioni)</div></div>  				    
    				  <?php endforeach ?>
    				</div>  				  
  				<?php endif ?>
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


    <div class="clear-both"/>			
    </div>
		
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  
  <?php if($ramo =='senato' ): ?>
    <?php echo link_to('senatori', '@parlamentari?ramo=senato') ?> /
    Sen. 
  <?php else: ?>
    <?php echo link_to('deputati', '@parlamentari?ramo=camera') ?> /
    On.
  <?php endif; ?>
  <?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?>
<?php end_slot() ?>