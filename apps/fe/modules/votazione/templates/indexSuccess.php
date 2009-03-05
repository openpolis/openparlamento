<?php use_helper('Date', 'sfRating') ?>

<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      <?php echo $ramo." - votazione n. ".$votazione->getNumeroVotazione()." (seduta n. ".$votazione->getOppSeduta()->getNumero(). " del ".format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy').")"  ?>  
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container">
<a name="top"></a>
  <div id="main">
  
   <div class="W25_100 float-right">
     
      esito della votazione:
      <?php echo $votazione->getEsito() ?>
      <br />
      voti di scarto: <?php echo $votazione->getMargine() ?>
       <br />
       <?php if ($ribelli): ?>
          numero di ribelli: <a href="#ribelli"><?php echo $votazione->getRibelli() ?></a>
       <?php endif; ?>	   

		    
      <br /><br />
             <?php echo include_component('votazione','chartPresenze', array('votazione' => $votazione, 'votantiComponent' => $votantiComponent, 'ramo' => $ramo)) ?>
       <?php echo include_component('votazione','chartEsito', array('votazione' => $votazione)) ?>

       <br />
      
       
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