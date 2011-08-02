<?php foreach ($lanci as $l) : ?>
<?php $lancio=OppAttoPeer::retrieveByPk($l) ?>
<li class="float-container">
	<div style="margin-right:30px;" class="float-right"><small>utenti:</small></div>
	<p style="color: #BEBEBE;font-size:11px;font-weight:bold;">
	<?php echo format_date($lancio->getDataPres(), 'dd/MM/yyyy') ?>, <?php echo $lancio->getOppTipoAtto()->getDescrizione() ?><?php echo ($lancio->getRamo()=='C') ? ' alla Camera' : ' al Senato' ?>
	<?php $f_signers= OppAttoPeer::doSelectPrimiFirmatari($lancio->getId()); ?>
	<?php if (count($f_signers)>0) : ?>
		<?php $c = new Criteria() ?>
		<?php $c->add(OppPoliticoPeer::ID, key($f_signers), Criteria::EQUAL); ?>
		<?php $f_signer = OppPoliticoPeer::doSelectOne($c) ?>
		<?php echo ' di '.$f_signer->getCognome().(count($f_signers)>1 ? ' e altri' : '') ?>
	<?php endif; ?>   
	</p>			
	<div class="user-votes"><span class="green thumb-up"><?php echo $lancio->getUtFav() ?></span> <span class="red thumb-down"><?php echo $lancio->getUtContr() ?></span></div>					
	<p> <?php echo link_to($lancio->getRamo().".".$lancio->getNumfase()." [".$lancio->getTitoloAggiuntivo()."]", 'atto/index?id='.$lancio->getId()) ?></p>
	<div class="user-comments"><?php echo $lancio->getNbCommenti() ?><strong> commenti</strong></div>
</li>	
<?php endforeach ?>