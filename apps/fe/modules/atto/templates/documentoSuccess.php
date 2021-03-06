<div class="row" id="tabs-container">
    <ul class="float-container tools-container" id="content-tabs">
      <li class="current"><h2><?php echo $documento->getTitolo() ?></h2></li>
    </ul>
</div>

<div class="row">
	<div class="twelvecol">
		
		<?php if ($sf_user->isAuthenticated() && !$sf_user->hasCredential('noemend')): ?>
		<p class="tools-container float-left float-container"><a class="ico-help" href="#">come posso commentare questo documento</a></p>
		<div class="clear-both"></div>
		<p><?php echo image_tag('/images/emend-help.png') ?></p>                
		<?php endif ?>
		
		<?php if($documento->getUrlTesto() && ($documento->getOppAtto()->getTipoAttoId()==1 || $documento->getOppAtto()->getTipoAttoId()>11)): ?>
			<div><b><?php echo link_to('link alla fonte', $documento->getUrlTesto(), array('class' => 'external')) ?></b>
			<?php if($documento->getUrlPdf()): ?>
				&nbsp;|&nbsp;
				<b><?php echo link_to('scarica il documento in PDF', $documento->getUrlPdf(), array('class' => 'external')) ?></b>
			<?php endif; ?>
			</div>
		<?php elseif ($documento->getOppAtto()->getTipoAttoId()>1 && $documento->getOppAtto()->getTipoAttoId()<=11):?>
			<div><b><?php echo link_to('link alla fonte', 'http://aic.camera.it/aic/scheda.html?core=aic&numero='.$documento->getOppAtto()->getNumfase().'&ramo='.$documento->getOppAtto()->getRamo().'&leg='.$documento->getOppAtto()->getLegislatura(), array('class' => 'external')) ?></b>
			<b><?php echo link_to('scarica il documento in PDF', 'http://aic.camera.it/aic/scheda.pdf?core=aic&numero='.$documento->getOppAtto()->getNumfase().'&ramo='.$documento->getOppAtto()->getRamo().'&leg='.$documento->getOppAtto()->getLegislatura(), array('class' => 'external')) ?></b>
			</div>
		<?php endif; ?>
		
		<br />
      <h5 class="subsection">Atto a cui si riferisce:<br /> <?php echo link_to(Text::denominazioneAtto($documento->getOppAtto(), 'list'), 'atto/index?id='.$documento->getOppAtto()->getId()) ?></h5>
      <br /><br />


		<?php if($documento->getTesto()): ?>
			<?php if($documento->getOppAtto()->getTipoAttoId()>1 && $documento->getOppAtto()->getTipoAttoId()<12 ): ?>
			<?php echo "<div id='testo_atto'><br />".$documento->getTesto()."</div>" ?>
			<?php else: ?>
			<?php echo $documento->getTesto() ?>
			<?php endif; ?>    
		<?php else: ?>
			<?php if($documento->getUrlPdf()): ?>
			<b>Documento disponibile solo in formato PDF.<?php echo link_to(' Scarica il documento', $documento->getUrlPdf(), array('class' => 'external')) ?>.</b>
			<?php else: ?>
			testo non disponibile
			<?php endif; ?>    
		<?php endif; ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php if ($documento->getOppAtto()->getTipoAttoId()==1): ?>
	<?php echo link_to("disegni di legge", "@attiDisegni") ?>
    <?php endif; ?> 
    	
    <?php if ($documento->getOppAtto()->getTipoAttoId()==12): ?>
	<?php echo link_to("decreti legge", "@attiDecretiLegge") ?>
    <?php endif; ?> 
    
    <?php if ($documento->getOppAtto()->getTipoAttoId()==15 || $documento->getOppAtto()->getTipoAttoId()==16 || $documento->getOppAtto()->getTipoAttoId()==17): ?>
	<?php echo link_to("decreti legislativi", "atto/decretoLegislativoList") ?>
    <?php endif; ?> 
    
    <?php if (($documento->getOppAtto()->getTipoAttoId()<12 && $documento->getOppAtto()->getTipoAttoId()!=1) || $documento->getOppAtto()->getTipoAttoId()==14): ?>
	<?php echo link_to("atti non legislativi", "@attiNonLegislativi") ?>
    <?php endif; ?> 
    /
    <?php echo link_to(Text::denominazioneAttoShort($documento->getOppAtto()),'atto/index?id='.$documento->getOppAtto()->getId()) ?>
     /
    <?php echo $documento->getTitolo() ?> 
<?php end_slot() ?>



  
