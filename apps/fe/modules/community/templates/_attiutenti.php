 <?php use_helper('Date', 'Javascript') ?> 
 
 <div id="proposte_indicator" style="display:none">
  <div class="indicator"></div>
</div>
 
  <ul class="section-tab-switch float-container tools-container">
  <?php if ($type == 'voti'): ?>
    <li class="current">pi&ugrave; votati</li> 
    <li><?php echo link_to_remote('pi&ugrave; commentati', 
                                array( 'update' => 'atti_community', 
                                       'url' => "/community/attiutenti?type=commenti",
                                       '404'     => "alert('Not found...? Wrong URL...?')",
                                       'loading'  => "Element.show('proposte_indicator')",
                                       'complete' => "Element.hide('proposte_indicator')"
                                       )); ?></li>
    <li><?php echo link_to_remote('pi&ugrave; monitorati', 
                                array( 'update' => 'atti_community', 
                                       'url' => "/community/attiutenti?type=monitor",
                                       '404'     => "alert('Not found...? Wrong URL...?')",
                                       'loading'  => "Element.show('proposte_indicator')",
                                       'complete' => "Element.hide('proposte_indicator')"
                                       )); ?></li>                                  
  <?php endif ?>
  <?php if ($type == 'commenti'): ?>
    
    <li><?php echo link_to_remote('pi&ugrave; votati', 
                                array( 'update' => 'atti_community', 
                                       'url' => "/community/attiutenti?type=voti",
                                       '404'     => "alert('Not found...? Wrong URL...?')",
                                       'loading'  => "Element.show('proposte_indicator')",
                                       'complete' => "Element.hide('proposte_indicator')"
                                       )); ?></li>
    <li class="current">pi&ugrave; commentati</li>                                    
    <li><?php echo link_to_remote('pi&ugrave; monitorati', 
                                array( 'update' => 'atti_community', 
                                       'url' => "/community/attiutenti?type=monitor",
                                       '404'     => "alert('Not found...? Wrong URL...?')",
                                       'loading'  => "Element.show('proposte_indicator')",
                                       'complete' => "Element.hide('proposte_indicator')"
                                       )); ?></li>                                  
  <?php endif ?>
  <?php if ($type == 'monitor'): ?>
    
    <li><?php echo link_to_remote('pi&ugrave; votati', 
                                array( 'update' => 'atti_community', 
                                       'url' => "/community/attiutenti?type=voti",
                                       '404'     => "alert('Not found...? Wrong URL...?')",
                                       'loading'  => "Element.show('proposte_indicator')",
                                       'complete' => "Element.hide('proposte_indicator')"
                                       )); ?></li>
                                        
    <li><?php echo link_to_remote('pi&ugrave; commentati', 
                                array( 'update' => 'atti_community', 
                                       'url' => "/community/attiutenti?type=commenti",
                                       '404'     => "alert('Not found...? Wrong URL...?')",
                                       'loading'  => "Element.show('proposte_indicator')",
                                       'complete' => "Element.hide('proposte_indicator')"
                                       )); ?></li>                                  
  <li class="current">pi&ugrave; monitorati</li>
  <?php endif ?>
</ul>	

<ul id="law-n-acts-proposals">
<?php foreach ($atti as $atto): ?>
		<li class="float-container">
		        <div class="float-right" style="margin-right:30px;"><small>utenti:</small></div>
			<p><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?>, <?php echo $atto->getOppTipoAtto()->getDescrizione() ?><?php echo ($atto->getRamo()=='C') ? ' alla Camera' : ' al Senato' ?>
			<?php $f_signers= OppAttoPeer::doSelectPrimiFirmatari($atto->getId()); ?>
		        <?php if (count($f_signers)>0) : ?>
		               <?php $c = new Criteria() ?>
		               <?php $c->add(OppPoliticoPeer::ID, key($f_signers), Criteria::EQUAL); ?>
		               <?php $f_signer = OppPoliticoPeer::doSelectOne($c) ?>
		               <?php echo ' di '.$f_signer->getCognome().(count($f_signers)>1 ? ' e altri' : '') ?>
		         <?php endif; ?>   
			</p>

			<div class="user-votes"><span class="green thumb-up"><?php echo $atto->getUtFav() ?></span> <span class="red thumb-down"><?php echo $atto->getUtContr() ?></span></div>					
			<p> <?php echo link_to(Text::denominazioneAtto($atto, 'list'), 'atto/index?id='.$atto->getId()) ?></p>
			<div class="user-comments"><?php echo $atto->getNbCommenti() ?><strong> commenti</strong></div>
		</li>
<?php endforeach; ?> 		 
		
</ul>		