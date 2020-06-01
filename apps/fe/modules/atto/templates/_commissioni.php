<h5 class="subsection">commissioni assegnatarie in sede referente:</h5>
<p class="tools-container indent">
  <?php echo link_to('cosa sono le commissioni', '#', array('class' => 'ico-help')) ?>
</p>
<div class="help-box float-container" style="display: none;">
  <div class="inner float-container">
    <div class="go-wikipedia">
      <?php echo link_to('approfondisci su<br />'.image_tag('ico-wikipedia.png', array('alt' => 'wikipedia').'<strong>Wikipedia</strong>'), 'http://it.wikipedia.org/wiki/Commissione_parlamentare') ?>
	</div>
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close action')) ?>
    <h5>cosa sono le commissioni ?</h5>
    <p>La <b>Commissione in sede referente</b> di norma esamina un disegno di legge e ne prepara il testo per la successiva discussione nell'Aula (o Assemblea) della Camera o del Senato. Al termine dell'esame la Commissione approva il testo e nomina un relatore che riferir&agrave; all'Assemblea (di qui "sede referente") cio&egrave; presenter&agrave; il testo e il lavoro svolto (approfondisci su <a href="http://it.wikipedia.org/wiki/Commissione_parlamentare#Commissione_in_sede_referente">Wikipedia</a>).<br />
       La <b>Commissione in sede redigente</b> si occupa non solo di esaminare il testo di un disegno di legge (DDL) - come avviene di norma - ma anche di redigere e approvare uno ad uno gli articoli di cui si compone. In questo modo la procedura &egrave; pi&ugrave; breve perch&egrave; poi in Aula (o Assemblea) al Senato e alla Camera si procede speditamente alla votazione finale. (approfondisci su <a href="http://it.wikipedia.org/wiki/Commissione_parlamentare#Commissione_in_sede_redigente">Wikipedia</a>).<br />
       La <b>Commissione in sede deliberante</b> (legislativa), in alcuni casi sempre pi&ugrave; rari, pu&ograve; essere incaricata non solo di elaborare il testo di un disegno di legge - DDL - (come avviene di norma) ma anche di approvarlo definitivamente. In questi casi la Commissione si dice legislativa o deliberante perch&egrave; fa la legge senza passare per l'Aula (Assemblea) della Camera o del Senato. (approfondisci su <a href="http://it.wikipedia.org/wiki/Commissione_parlamentare#Commissione_in_sede_legislativa_.28o_deliberativa.29">Wikipedia</a>).</p>
  </div>
</div>

<ul class="square-bullet">
  <?php foreach($commissioni as $id => $commissione): ?>
    <?php if($commissione->getTipo() != 'Consultiva'): ?>
	  <li>
        <?php if($commissione->getOppSede()->getRamo()=='S'): ?>
          <?php $sede_comm="Senato" ?>
		  <?php if($commissione->getOppSede()->getTipologia()!='Commissione speciale'): ?>
          	<?php $uri_comm="@commissioni_senato" ?>
		   <?php else : ?>
			   <?php $uri_comm="@commissioni_bicamerali" ?>
			<?php endif; ?>
        <?php elseif ($commissione->getOppSede()->getRamo()=='C') : ?>
          <?php $sede_comm="Camera" ?>
		  <?php if($commissione->getOppSede()->getTipologia()!='Commissione speciale'): ?>
          	<?php $uri_comm="@commissioni_camera" ?>
		   <?php else : ?>
			   <?php $uri_comm="@commissioni_bicamerali" ?>
			<?php endif; ?>
        <?php elseif ($commissione->getOppSede()->getRamo()=='CS') : ?>
          <?php $sede_comm="Bicamerale" ?>
          <?php $uri_comm="@commissioni_bicamerali" ?>
        <?php endif; ?>
        <?php echo "Sede ".$commissione->getTipo().": ".$sede_comm." ".link_to($commissione->getOppSede()->getDenominazione(),$uri_comm.'#'.$commissione->getOppSede()->getId()) ?>
      </li>
	<?php else: ?>
      <?php $consultive_count++; ?>  	
	<?php endif; ?>  
  <?php endforeach; ?>	
</ul>

<?php if($consultive_count > 0): ?>
  <p class="indent">guarda le commissioni in sede consultiva
    [ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]
  </p>
  
  <div class="more-results float-container" style="display: none;">
    <ul class="square-bullet">
      <?php foreach($commissioni as $id => $commissione): ?>
        <?php if($commissione->getTipo() == 'Consultiva'): ?>
	        <li>
              <?php if($commissione->getOppSede()->getRamo()=='S'): ?>
                <?php $sede_comm="Senato" ?>
                <?php $uri_comm="@commissioni_senato" ?>
              <?php elseif ($commissione->getOppSede()->getRamo()=='C') : ?>
                <?php $sede_comm="Camera" ?>
                <?php $uri_comm="@commissioni_camera" ?>
              <?php elseif ($commissione->getOppSede()->getRamo()=='CS') : ?>
                <?php $sede_comm="Bicamerale" ?>
                <?php $uri_comm="@commissioni_bicamerali" ?>
              <?php endif; ?>
              <?php echo $sede_comm." ".link_to($commissione->getOppSede()->getDenominazione(),$uri_comm.'#'.$commissione->getOppSede()->getId()) ?>
            </li>
        <?php endif; ?>  
      <?php endforeach; ?>	
    </ul>
    <div class="more-results-close">[ <?php echo link_to('chiudi', '#', array('class'=>'btn-close action') ) ?> ]</div>
  </div>
<?php endif; ?>