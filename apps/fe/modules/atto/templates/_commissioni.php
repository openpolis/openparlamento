<h5 class="subsection">commissioni assegnatarie in sede referente:</h5>
<p class="tools-container indent">
  <?php echo link_to('cosa sono le commissioni', '#', array('class' => 'ico-help')) ?>
</p>
<div class="help-box float-container" style="display: none;">
  <div class="inner float-container">
    <div class="go-wikipedia">
      <?php echo link_to('approfondisci su<br />'.image_tag('ico-wikipedia.png', array('alt' => 'wikipedia').'<strong>Wikipedia</strong>'), '#') ?>
	</div>
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close action')) ?>
    <h5>cosa sono le commissioni ?</h5>
    <p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
  </div>
</div>

<ul class="square-bullet">
  <?php foreach($commissioni as $id => $commissione): ?>
    <?php if($commissione->getTipo() != 'Consultiva'): ?>
	  <li>
        <?php if($commissione->getOppSede()->getRamo()=='S'): $sede_comm="Senato" ?>
          <?php else: $sede_comm="Camera" ?>
        <?php endif; ?>
        <?php echo "Sede ".$commissione->getTipo().": ".$sede_comm." Commissione ".$commissione->getOppSede()->getDenominazione(); ?>
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
            <?php if($commissione->getOppSede()->getRamo()=='S'): $sede_comm="Senato" ?>
              <?php else: $sede_comm="Camera" ?>
            <?php endif; ?>
            <?php echo $sede_comm." Commissione ".$commissione->getOppSede()->getDenominazione(); ?>
          </li>
        <?php endif; ?>  
      <?php endforeach; ?>	
    </ul>
    <div class="more-results-close">[ <?php echo link_to('chiudi', '#', array('class'=>'btn-close action') ) ?> ]</div>
  </div>
<?php endif; ?>