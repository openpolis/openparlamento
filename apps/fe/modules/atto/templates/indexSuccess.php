<?php use_helper('Date', 'I18N') ?>

<?php include_partial('atto_tabs', array('atto' => $atto, 'current' => 'atto', 
                                         'nb_comments' => $atto->getNbPublicComments(),
                                         'nb_emendamenti' => $atto->countOppAttoHasEmendamentos())) ?>

<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">
    
    <div class="W25_100 float-right">
    <?php if($atto->getTipoAttoId()!=13 && $atto->getTipoAttoId()!=14): ?>
      <?php echo include_component('atto', 'monitor_n_vote', array('atto' => $atto)); ?>

      <?php echo include_partial('news/newsbox', 
                                 array('title' => 'Atto', 
                                       'all_news_url' => '@news_atto?id='.$atto->getId(), 
                                       'news'   => oppNewsPeer::getNewsForItem('OppAtto', $atto->getId(), 10),
                                       'context' => 0,
                                       'rss_link' => '@feed_atto?id='.$atto->getId()));  
      ?>
       <?php endif; ?>  
    </div>
    
    <div class="W73_100 float-left">
      
      <?php if ($sf_flash->has('subscription_promotion')): ?>
        <div class="flash-messages">
          <?php echo $sf_flash->get('subscription_promotion') ?>
        </div>
      <?php endif; ?>
      
      
     <?php if($atto->getTipoAttoId()!=13 ): ?>
     
      <span style="color:#888888;font-size:16px;font-weight:bolder">
        <?php if($atto->getTipoAttoId()!=14 ): ?>
          <?php if($atto->getRamo()): ?>
            <?php if($atto->getRamo()=='C'): ?>
              Camera,
            <?php endif; ?>  
             <?php if($atto->getRamo()=='S'): ?>
              Senato,
            <?php endif; ?>
          <?php endif; ?>          
            <?php echo $atto->getOppTipoAtto()->getDescrizione() ?>
       </span>
       <?php include_partial('attoWiki', array('titolo_wiki' => $titolo_wiki)) ?>
       <span style="color:#888888;font-size:16px;font-weight:bolder">
            
            <?php $f_signers= OppAttoPeer::doSelectPrimiFirmatari($atto->getId()); ?>
            <?php if (count($f_signers)>0) : ?>
               <?php $c = new Criteria() ?>
               <?php $c->add(OppPoliticoPeer::ID, key($f_signers), Criteria::EQUAL); ?>
               <?php $f_signer = OppPoliticoPeer::doSelectOne($c) ?>
                <?php if($atto->getTipoAttoId()==1 ): ?>
                   <?php echo ' presentato da ' ?>
                <?php else : ?>
                   <?php echo ' di ' ?>
                <?php endif; ?>      
               <?php echo link_to($f_signer->getNome().' '.$f_signer->getCognome(),'parlamentare/'.$f_signer->getId()).(count($f_signers)>1 ? ' e altri' : '') ?>
             <?php endif; ?>   
        <?php else: ?>
          <?php if($atto->getRamo()): ?>
            <?php if($atto->getRamo()=='C'): ?>
              Camera
            <?php endif; ?>  
             <?php if($atto->getRamo()=='S'): ?>
              Senato
            <?php endif; ?>
          <?php endif; ?>  
        <?php endif; ?>
      </span>
      
    
     <?php endif; ?>
	  
	   
	  
	  <!-- SINOSSI -->
	  <p class="synopsis">
            <?php echo Text::denominazioneAtto($atto, 'index') ?>    
          </p>
      
      <ul class="presentation float-container" style="margin-bottom:12px;">
        <li><h6>presentato il: <em><?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?></em></h6></li>
        
        <?php if($tipo_iniziativa != ''): ?>
          <li><h6>tipo di iniziativa: <em><?php echo $tipo_iniziativa ?></em></h6></li>
        <?php endif; ?>			  
        <?php if($link != '#'): ?>
          <li><?php echo link_to("link alla fonte", $link, array('class' => 'external', 'target' => '_blank')) ?></li>
        <?php endif; ?>		  
      </ul>
       <!-- tutto l'iter -->
       <?php if($status): ?>
       	    <ul class="presentation float-container" style="margin-bottom:12px;">
               <?php include_partial('status', array('status' => $status,'atto' => $atto)) ?>
               <?php if(count($iter_completo)!=0): ?>
	          <?php include_partial('iterCompleto', array('iter_completo' => $iter_completo,'atto' => $atto)) ?>
	       <?php endif; ?>
	    </ul>
	    
	    
	    <!-- Iter grafico per ddl e dl -->
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
	<?php endif; ?>						  
	    
	  
	    
	  
      <!-- partial per la visualizzazione e l'edit-in-place dei tags associati all'atto -->
      <?php echo include_component('deppTagging', 'edit', array('content' => $atto)); ?>

      <!-- component per l'elenco dei documenti -->
      <a name="documenti"></a>
      <?php echo include_component('atto', 'documenti', array('atto' => $atto, 'titolo_wiki' => $titolo_wiki) ); ?>
      
      
      <!-- DESCRIZIONE -->
      <div class="wiki-box-container">
    	<h5 class="description">descrivi insieme agli altri utenti questo atto:</h5>
    	<p style="padding:5px;">qui sotto puoi inserire o modificare la descrizione per questa votazione.
    	<?php if ($sf_user->isAuthenticated()) : ?>
    	   <?php echo 'Clicca su "modifica"' ?>
    	<?php else : ?>
    	   Per modificare <?php echo link_to('effettua il login', '@sf_guard_signin') ?> 
    	<?php endif ?>     
    	</p>
    	
      <!-- partial per la descrizione wiki -->	
      <?php echo include_component('nahoWiki', 'showContent', array('page_name' => 'atto_' . $atto->getId() )) ?>
      </div>	
	
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
    <?php include_partial('atto/breadcrumbsAtti', array('atto' => $atto)) ?> /
    <?php echo Text::denominazioneAttoShort($atto) ?>
<?php end_slot() ?>
