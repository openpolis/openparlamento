<?php use_helper('Date', 'I18N') ?>

<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      <?php echo Text::denominazioneAttoShort($atto) ?>  
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container">
  <div id="main">
    
    <div class="W25_100 float-right">
      <?php echo include_component('atto', 'monitor_n_vote', array('atto' => $atto)); ?>

      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Atto', 
                                       'all_news_url' => '@news_atto?id='.$atto->getId(), 
                                       'news'   => NewsPeer::getNewsForItem('OppAtto', $atto->getId(), 10))); 
      ?>
    </div>
    
    <div class="W73_100 float-left">
      <h5 class="grey-888">
        <?php if($atto->getTipoAttoId()!=14): ?>
          <?php if($atto->getRamo()): ?>
            <?php if($atto->getRamo()=='C'): ?>
              Camera,
            <?php else: ?>
              Senato,
            <?php endif; ?>
          <?php endif; ?>          
          <?php echo $atto->getOppTipoAtto()->getDescrizione() ?>
        <?php else: ?>
          <?php if($atto->getRamo()): ?>
            <?php if($atto->getRamo()=='C'): ?>
              Camera
            <?php else: ?>
              Senato
            <?php endif; ?>
          <?php endif; ?>  
        <?php endif; ?>
      </h5>
	  
	   <?php include_partial('attoWiki', array('titolo_wiki' => $titolo_wiki)) ?>
	  
	  <!-- SINOSSI -->
	  <p class="synopsis">
        <?php echo Text::denominazioneAtto($atto, 'index') ?>            
      </p>
      
      <ul class="presentation float-container">
        <li><h6>presentato il: <em><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?></em></h6></li>
        
        <?php if($tipo_iniziativa != ''): ?>
          <li><h6>tipo di iniziativa: <em><?php echo $tipo_iniziativa ?></em></h6></li>
        <?php endif; ?>			  
        <?php if($link != '#'): ?>
          <li><?php echo link_to("link alla fonte", $link, array('class' => 'external', 'target' => '_blank')) ?></li>
        <?php endif; ?>		  
      </ul>
	  
	    
	  
      <!-- partial per la visualizzazione e l'edit-in-place dei tags associati all'atto -->
      <?php echo include_component('deppTagging', 'edit', array('content' => $atto)); ?>

      <!-- component per l'elenco dei documenti -->
      <?php echo include_component('atto', 'documenti', array('atto' => $atto, 'titolo_wiki' => $titolo_wiki) ); ?>
      
      
      <!-- DESCRIZIONE -->
    	<h5 class="description">descrivi questo atto:</h5>
    	<p class="micro-tip">qui sotto potete inserire, utilizzando il <a href="#" class="ico-help action">micro-wiki</a> le vostre descrizioni relative al disegno di legge</p>
    	<div class="help-box float-container" style="display: none;">
    		<div class="inner float-container">
    			<a href="#" class="ico-close action">chiudi</a><h5>come si usa il micro-wiki ?</h5>

    			<p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per.</p>
    		</div>
    	</div>
      <!-- partial per la descrizione wiki -->	
      <?php echo include_component('nahoWiki', 'showContent', array('page_name' => 'atto_' . $atto->getId() )) ?>
      
      <?php if($status): ?>
      <!-- rappresentazione grafica dell'iter -->
	  <?php include_partial('statoAvanzamento', 
	                      array('rappresentazioni_pred' => $rappresentazioni_pred, 
						  'atto' => $atto,
						  'rappresentazioni_this' => $rappresentazioni_this,
						  'rappresentazioni_succ' => $rappresentazioni_succ,
						  'leggi_this'            => $leggi_this,
						  'leggi_succ'            => $leggi_succ,
						  'lettura_parlamentare_precedente' => $lettura_parlamentare_precedente,
						  'lettura_parlamentare_successiva' => $lettura_parlamentare_successiva,
						  'lettura_parlamentare_ultima' => $lettura_parlamentare_ultima,
						  'legge'                       => $legge           )) ?>
						  
 	   <!-- tutto l'iter -->
	   <?php include_partial('status', array('status' => $status)) ?>
	
	   <?php if(count($iter_completo)!=0): ?>
	     <?php include_partial('iterCompleto', array('iter_completo' => $iter_completo)) ?>
	   <?php endif; ?>
	
	<?php endif; ?>
	
                           
	                            
	
	
	<!-- Firmatari -->
	    <?php include_component('atto', 'firmatari', 
	                            array('primi_firmatari' => $primi_firmatari, 'relatori' => $relatori, 'atto'=>$atto)) ?>

      <?php if(count($co_firmatari)!=0): ?>
        <?php include_partial('coFirmatari', 
	                      array('co_firmatari' => $co_firmatari, 'atto'=>$atto)) ?>						
	
	    <?php endif; ?>

      <?php if(count($votazioni)!=0): ?>
        <?php include_component('atto', 'votazioni', array('votazioni' => $votazioni)) ?>
      <?php endif; ?>

      <?php if(count($commissioni)!=0): ?>
	    <?php include_component('atto', 'commissioni', array('commissioni' => $commissioni)) ?>
      <?php endif; ?>

      <?php if(count($interventi)!=0): ?>
        <?php include_component('atto', 'interventi', array('interventi' => $interventi)) ?>
      <?php endif; ?> 	  

      <a name="monitoringusersdo"></a>
      <?php echo include_component('atto', 'monitoringusersdo', array('item' => $atto)); ?>

      <a name="prousersdo"></a>
      <?php echo include_component('atto', 'prousersdo', array('item' => $atto)); ?>

      <a name="antiusersdo"></a>
      <?php echo include_component('atto', 'antiusersdo', array('item' => $atto)); ?>
	  
    </div>

    <div class="clear-both"></div>

  </div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php if ($atto->getTipoAttoId()==1): ?>
	<?php echo link_to("disegni di legge", "atto/disegnoList") ?>
    <?php endif; ?> 
    	
    <?php if ($atto->getTipoAttoId()==12): ?>
	<?php echo link_to("decreti legge", "atto/decretoList") ?>
    <?php endif; ?> 
    
    <?php if ($atto->getTipoAttoId()==15 || $atto->getTipoAttoId()==16 || $atto->getTipoAttoId()==17): ?>
	<?php echo link_to("decreti legislativi", "atto/decretoLegislativoList") ?>
    <?php endif; ?> 
    
    <?php if (($atto->getTipoAttoId()<12 && $atto->getTipoAttoId()!=1) || $atto->getTipoAttoId()==14): ?>
	<?php echo link_to("atti non legislativi", "atto/attoNonLegislativoList") ?>
    <?php endif; ?> 

    /
    <?php echo Text::denominazioneAttoShort($atto) ?>

     
<?php end_slot() ?>
