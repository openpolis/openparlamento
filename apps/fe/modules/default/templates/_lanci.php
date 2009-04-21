<li class="float-container">
<?php if ($lancio[1]=='OppAtto') : ?>
	<div class="float-right" style="margin-right:30px;"><small>utenti:</small></div>
	<p>
	<?php echo format_date($lancio[0]->getDataPres(), 'dd/MM/yyyy') ?>, <?php echo $lancio[0]->getOppTipoAtto()->getDescrizione() ?><?php echo ($lancio[0]->getRamo()=='C') ? ' alla Camera' : ' al Senato' ?>
	<?php $f_signers= OppAttoPeer::doSelectPrimiFirmatari($lancio[0]->getId()); ?>
	<?php if (count($f_signers)>0) : ?>
		<?php $c = new Criteria() ?>
		<?php $c->add(OppPoliticoPeer::ID, key($f_signers), Criteria::EQUAL); ?>
		<?php $f_signer = OppPoliticoPeer::doSelectOne($c) ?>
		<?php echo ' di '.$f_signer->getCognome().(count($f_signers)>1 ? ' e altri' : '') ?>
	<?php endif; ?>   
	</p>			
	<div class="user-votes"><span class="green thumb-up"><?php echo $lancio[0]->getUtFav() ?></span> <span class="red thumb-down"><?php echo $lancio[0]->getUtContr() ?></span></div>					
	<p> <?php echo link_to(Text::denominazioneAtto($lancio[0], 'list'), 'atto/index?id='.$lancio[0]->getId()) ?></p>
	<div class="user-comments"><?php echo $lancio[0]->getNbCommenti() ?><strong> commenti</strong></div>
		     
<?php else: ?>
	<p><?php echo format_date($lancio[0]->getOppSeduta()->getData(), 'dd/MM/yyyy') ?>, <?php echo ($lancio[0]->getOppSeduta()->getRamo()=='C') ? ' votazione alla Camera' : ' votazione al Senato' ?>
	<?php if($lancio[0]->getEsito()=='APPROVATA'): ?>
		<?php $class = "green thumb-approved"; ?>
	<?php elseif($lancio[0]->getEsito()=='RESPINTA'): ?>
		<?php $class = "red thumb-rejected"; ?>
		<?php else: ?>
		<?php $class = ""; ?>
	<?php endif; ?>			 			
	<p><?php echo link_to($lancio[0]->getTitolo(), 'votazione/index?id='.$lancio[0]->getId()) ?></p>
	<span class="<?php echo $class ?>"><?php echo $lancio[0]->getEsito() ?></span>
<?php endif; ?>
</li>