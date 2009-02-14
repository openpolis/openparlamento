<?php use_helper('Date', 'sfRating') ?>

<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      <?php echo $ramo." - votazione n. ".$votazione->getNumeroVotazione()." (seduta n. ".$votazione->getOppSeduta()->getNumero(). " del ".format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy').")"  ?>  
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container">
  <div id="main">
  
   <div class="W25_100 float-right">
      qui ci va l'esito
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
      qui va incluso il wiki
      
      <br />
       <ul class="presentation float-container">
        <li><h6>Ci sono <a href="#">2 commenti</a> degli utenti (aggiungi anche il <a href="#">tuo commento</a>)</h6></li>
       </ul> 
      
      
      <h5 class="subsection">come hanno votato i gruppi</h5>
      <?php include_partial('gruppi', array('votazione' => $votazione, 'risultati' => $risultati)) ?> 
      
      <?php if ($ribelli): ?>
           <?php include_partial('ribelli', array('ribelli' => $ribelli, 'voto_gruppi' => $voto_gruppi)) ?>  
       <?php endif; ?> 
      
      <h5 class="subsection">come hanno votato i <?php echo ($ramo=='Camera' ? 'deputati' : 'senatori') ?></h5>
      <?php include_partial('votanti', array('votanti' => $votanti)) ?>  
      
      
   </div>

  </div>
</div>  

<h1><?php echo $ramo ?></h1>
<h2>Legislatura <?php echo $votazione->getOppSeduta()->getLegislatura() ?></h2>
<br />
<h3>seduta n&deg; <?php echo $votazione->getOppSeduta()->getNumero() ?> del <?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></h3>
<h3>VOTAZIONE <?php echo $votazione->getTitolo() ?></h3>
<h3>maggioranza: <?php echo $votazione->getMaggioranza() ?></h3>
<h3>esito: <?php echo $votazione->getEsito() ?></h3>
<h4><?php echo link_to('fonte', $votazione->getUrl(), array('target'=>'_blank')) ?></h4>
<br />


<!-- partial per la visualizzazione e l'edit-in-place dei tags associati al ddl -->
<?php echo include_component('deppTagging', 'edit', array('content' => $votazione)); ?>

<!-- blocco rating -->
<?php echo sf_rater($votazione) ?>

<!-- blocco dei commenti -->
<div id="comments-block">
    <hr />

    <a href="#top" class="go-top">torna su</a>
    <a name="comments"></a>
    <?php include_partial('deppCommenting/commentsList', array('content' => $votazione)) ?>

    <hr/>

    <?php include_component('deppCommenting', 'addComment',  
                            array('content' => $votazione,
                                  'read_only' => sfConfig::get('app_comments_enabled', false),
                                  'automoderation' => sfConfig::get('app_comments_automoderation', 'captcha')) ) ?>

    <hr/>
</div>


<?php include_partial('gruppi', array('votazione' => $votazione, 'risultati' => $risultati)) ?> 
<br />
<br />
<?php if ($ribelli): ?>
  <?php include_partial('ribelli', array('ribelli' => $ribelli)) ?>  
  <br />
  <br />
<?php endif; ?>  			
<?php include_partial('votanti', array('votanti' => $votanti)) ?>  