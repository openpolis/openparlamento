<?php use_helper('deppVotingYesNo', 'deppPrioritising', 'deppLaunching', 'deppOmnibus') ?>

<div id="monitor-n-vote">

  <h6>monitora questo atto</h6>
  <p class="tools-container"><a class="ico-help" href="#">che significa monitorare</a></p>
  		<div style="display: none;" class="help-box float-container">
  			<div class="inner float-container">

  				<a class="ico-close" href="#">chiudi</a><h5>che significa monitorare ?</h5>
  				<p>Registrandoti e entrando nel sito puoi attivare il monitoraggio per atti, parlamentari e argomenti. Da quel momento nella tua pagina personale e nella tua email riceverai tutti gli aggiornamenti riferiti agli elementi che stai monitorando.<br />
  				</p>
  			</div>
  		</div>
  <!-- component per la gestione del monitoring di questo atto -->
  <?php echo include_component('monitoring', 'manageItem', 
                               array('item' => $atto, 'item_type' => 'atto')); ?>
  <hr class="dotted" />			

  <h6>sei favorevole o contrario?</h6>

  <!-- blocco voting -->
  <?php include_component('deppVoting', 'votingBlock', array('object' => $atto)) ?>
  <hr class="dotted" />
  
   <!-- blocco lanci home x admin, priorita atti e flag omnibus -->
  <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
    <h6>lanci in home page</h6>
    <?php echo include_partial('deppLaunching/launcher', array('object' => $atto, 'namespace' => 'home')); ?>    
    <hr class="dotted" />

    <h6>in evidenza per CittadinoLex</h6>
    <?php echo include_partial('deppLaunching/launcher', array('object' => $atto, 'namespace' => 'lex')); ?>    
    <hr class="dotted" />

    <h6>assegna priorit&agrave; a questo atto</h6>
    <?php echo depp_prioritising_block($atto,
        $sf_flash->has('depp_prioritising_message')?$sf_flash->get('depp_prioritising_message'):'') ?>

    <h6>&egrave; atto <em>omnibus</em>?</h6>
    <?php echo depp_omnibus_block($atto,
        $sf_flash->has('depp_omnibus_message')?$sf_flash->get('depp_omnibus_message'):'') ?>
    
  <?php endif ?>
</div>
