<?php use_helper('Date', 'sfRating') ?>

<?php include_partial('votazione_tabs', array('votazione' => $votazione, 'current' => 'votazione', 'nb_comments' => $votazione->getNbPublicComments(), 'ramo' => $ramo)) ?>

<div id="content" class="tabbed float-container">
<a name="top"></a>
  <div id="main">
  
   <div class="W25_100 float-right">
     <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('administrator')): ?>
       <h6>lanci in home page</h6>
       <?php echo include_partial('deppLaunching/launcher', array('object' => $votazione, 'namespace' => 'home')); ?>    
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
        <?php if($votazione->getUrl()): ?>
          <li><?php echo link_to("link alla fonte", $votazione->getUrl(), array('class' => 'external', 'target' => '_blank')) ?></li>
        <?php endif; ?>		  
      </ul>
      
      <?php if ($voto_atti): ?>
          <?php if (count($voto_atti)>1): ?>
              <h5 class="subsection">la votazione si riferisce agli atti:</h5>
           <?php else : ?>   
              <h5 class="subsection">la votazione si riferisce all'atto:</h5>
           <?php endif; ?>    
           <?php include_partial('atti', array( 'voto_atti' => $voto_atti)) ?>  
       <?php endif; ?> 
	 
	 
      <!-- DESCRIZIONE -->
    	<h5 class="description">descrivi questa votazione:</h5>
    	<p class="micro-tip">qui sotto potete inserire, utilizzando il <a href="#" class="ico-help action">micro-wiki</a> le vostre descrizioni relative a questa votazione</p>
    	<div class="help-box float-container" style="display: none;">
    		<div class="inner float-container">
    			<a href="#" class="ico-close action">chiudi</a><h5>come si usa il micro-wiki ?</h5>

    			<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per.</p>
    		</div>
    	</div>
	
	
      <!-- partial per la descrizione wiki -->	
      <?php echo include_component('nahoWiki', 'showContent', array('page_name' => 'votazione_' . $votazione->getId() )) ?>
      <?php include_partial('deppCommenting/commentsNumber', array('content' => $votazione)) ?>
      
   
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
       
      <!-- blocco dei commenti -->
      <a name="comment"></a>
      <div id="comments-block">
        <a name="comments"></a>
        <?php include_partial('deppCommenting/commentsList', array('content' => $votazione)) ?>
    
        <hr/>
    
        <?php include_component('deppCommenting', 'addComment', 
                                array('content' => $votazione,
                                      'read_only' => sfConfig::get('app_comments_enabled', false),
                                      'automoderation' => sfConfig::get('app_comments_automoderation', 'captcha')) ) ?>
    
        <hr/>
      </div>      
      
      
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