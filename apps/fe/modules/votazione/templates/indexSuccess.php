<?php use_helper('Date', 'sfRating') ?>

<?php include_partial('votazione_tabs', array('votazione' => $votazione, 'current' => 'votazione', 'nb_comments' => $votazione->getNbPublicComments(), 'ramo' => $ramo)) ?>

<div id="content" class="tabbed float-container">
<a name="top"></a>
  <div id="main">
  
   <div class="W25_100 float-right">
    
     <!-- blocco voting -->
     <?php if ($sf_user->isAuthenticated() && ($sf_user->hasCredential('amministratore') || $sf_user->hasCredential('adhoc'))): ?>
       <?php include_component('deppVoting', 'votingBlock', array('object' => $votazione)) ?>
       <hr class="dotted" />
     <?php endif ?>

     <!-- blocco voti chiave -->
     <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
       <h6>Lancia come relevant-vote</h6>
       <?php echo include_partial('deppLaunching/launcher', array('object' => $votazione, 'namespace' => 'relevant_vote')); ?>    
        <br />
       <hr class="dotted" />
       <h6>Lancia come key-vote</h6>
       <?php echo include_partial('deppLaunching/launcher', array('object' => $votazione, 'namespace' => 'key_vote')); ?>    
        <br />
       <hr class="dotted" />
     <?php endif ?>
    
    
     
    <div style="background-color:#f7f7ff; padding: 5px;">
     <div style="background-color:#fff; padding:5px; color:#828199; font-weight:bold; font-size:15px; border: 1px solid #e4e4e8;">esito della votazione</div>
     <div style="padding: 5px;">
     <?php if (($votazione->getEsito()=='APPROVATA') && (strtolower($votazione->getTitolo())!='votazione annullata')) : ?>
          <?php echo image_tag('ico-votazione-yes.png', array('style' => 'vertical-align: middle; padding: 0 8px 0 0')) ?>	
          <span style="background-color: #39aa2d; color:white; font-weight:bold; font-size:16px; padding: 5px;"><?php echo $votazione->getEsito() ?></span>
      <?php else : ?>
          <?php if (strtolower($votazione->getTitolo())!='votazione annullata') : ?>
             <?php echo image_tag('ico-votazione-no.png', array('style' => 'vertical-align: middle; padding: 0 8px 0 0')) ?>	
             <span style="background-color: #e10032; color:white; font-weight:bold; font-size:16px; padding: 5px;"><?php echo $votazione->getEsito() ?></span>
           <?php else : ?> 
             <div style="padding: 5px;"><span style="background-color: #e10032; color:white; font-weight:bold; font-size:16px; padding: 5px;">ANNULLATA</span></div> 
           <?php endif ?> 
      <?php endif ?>    
      
      <div style="border-bottom:1px dotted #4E8480; padding:10px 5px 5px 10px;"></div>
    </div>
     <div style="padding: 5px">
     <div style="background-color:white; padding:5px; font-weight:bold; font-size:16px; color:#39aa2d;">FAVOREVOLI: <?php echo $votazione->getFavorevoli()." (".round($votazione->getFavorevoli()*100/($votazione->getFavorevoli()+$votazione->getContrari()+$votazione->getAstenuti()),1)."%)" ?></div>
      <br />
      <div style="background-color:white; padding:5px; font-weight:bold; font-size:16px; color:#e10032;">CONTRARI: <?php echo $votazione->getContrari()." (".round($votazione->getContrari()*100/($votazione->getFavorevoli()+$votazione->getContrari()+$votazione->getAstenuti()),1)."%)" ?></div>
      <br />
      <div style="background-color:white; padding:5px; font-weight:bold; font-size:16px;">ASTENUTI: <?php echo $votazione->getAstenuti()." (".round($votazione->getAstenuti()*100/($votazione->getFavorevoli()+$votazione->getContrari()+$votazione->getAstenuti()),1)."%)" ?></div>
      <br />
      <div style="background-color:white; padding:5px; font-weight:bold; font-size:14px;">voti di scarto: <?php echo $votazione->getMargine() ?></div> 
       <br />
       <?php if ($ribelli): ?>
          <div style="background-color:white; padding:5px; font-weight:bold; font-size:14px;">parlamentari ribelli: <a href="#ribelli"><?php echo $votazione->getRibelli() ?></a></div>
          <div style="border-bottom:1px dotted #4E8480; padding:10px 5px 5px 10px;"></div>
       <?php endif; ?>
     </div>  	
      
       

		    
      <br /><br />
             <?php echo include_component('votazione','chartPresenze', array('votazione' => $votazione, 'votantiComponent' => $votantiComponent, 'ramo' => $ramo)) ?>
       <?php //echo include_component('votazione','chartEsito', array('votazione' => $votazione)) ?>

       <br />
      
    </div>    
   </div>
    
   <div class="W73_100 float-left"> 
  
      <p class="synopsis">
        <?php echo $votazione->getTitolo() ?>
      </p>
        
      <ul class="presentation float-container"> 
        <li>
          <!-- bottone facebook -->
          <span style="vertical-align:top;"><a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">condividi</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script></span>
        </li>  
        <?php if($votazione->getUrl()): ?>
          <li><?php echo link_to("link alla fonte ufficiale", $votazione->getUrl(), array('class' => 'external', 'target' => '_blank')) ?></li>
        <?php endif; ?>		  
      </ul> 
      
      <?php if ($voto_atti || $voto_ems): ?> 
          <?php if (count($voto_atti)>1 || $voto_ems>1): ?>
              <h5 class="subsection">la votazione si riferisce agli atti:</h5>
           <?php else : ?>   
              <h5 class="subsection">la votazione si riferisce all'atto:</h5>
           <?php endif; ?>    
           <?php include_partial('atti', array( 'voto_atti' => $voto_atti,'voto_ems' => $voto_ems)) ?>  
       <?php endif; ?> 
	 
	 
      <!-- DESCRIZIONE -->
      <div class="wiki-box-container">
    	<h5 class="description">descrivi insieme agli altri utenti questa votazione:</h5>
    	<p style="padding:5px;">qui sotto puoi inserire o modificare la descrizione per questa votazione.
    	<?php if ($sf_user->isAuthenticated()) : ?>
    	   <?php echo 'Clicca su "modifica"' ?>
    	<?php else : ?>
    	   Per modificare <?php echo link_to('effettua il login', '@sf_guard_signin') ?> 
    	<?php endif ?>     
    	</p>
    	
	
	
      <!-- partial per la descrizione wiki -->	
      <?php echo include_component('nahoWiki', 'showContent', array('page_name' => 'votazione_' . $votazione->getId() )) ?>
      
      </div>
      
   
      <h5 class="subsection">come hanno votato i gruppi</h5>
      <?php include_partial('gruppi', array('votazione' => $votazione, 'risultati' => $risultati)) ?> 
      
     </div>  
     
    
      
      <?php if ($ribelli): ?>
      
      <div class="W100_100 float-left">
        <div class="W40_100 float-right"> 
          <?php echo include_component('votazione','chartRibelli', array('votazione' => $votazione, 'ribelli' => $ribelli)) ?>
        </div>  
        
        <div class="W56_100 float-left">
        <a name="ribelli"></a>
           <?php include_partial('ribelli', array('ribelli' => $ribelli, 'voto_gruppi' => $voto_gruppi)) ?> 
         </div>
       </div>    
            
            
       <?php endif; ?> 
    
       
       <div class="W100_100 float-left"> 
         <div class="W40_100 float-right">
           <?php echo include_component('votazione','chartFavorevoli', array('votazione' => $votazione, 'risultati' => $risultati, 'votantiComponent' => $votantiComponent, 'ramo' => $ramo)) ?>
        </div>   
       <div class="W56_100 float-left">
      <h5 class="subsection">come hanno votato tutti i <?php echo ($ramo=='Camera' ? 'deputati' : 'senatori') ?></h5>
      <?php include_partial('votanti', array('votanti' => $votanti)) ?>
      
      
   </div>
   </div>

  </div>
</div>  

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('votazioni', '@votazioni') ?>
    /
  <?php $votazione = OppVotazionePeer::retrieveByPk($sf_params->get('id')); ?>
  <?php echo $votazione->getTitolo(); ?>
<?php end_slot() ?>
