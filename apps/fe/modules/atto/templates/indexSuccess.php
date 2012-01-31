<?php use_helper('Date', 'I18N') ?>

<div class="row">
	<div class="twelvecol">
		<?php include_partial('atto_tabs', array('atto' => $atto, 'current' => 'atto', 
		                                         'nb_comments' => $atto->getNbPublicComments(),
		                                         'nb_emendamenti' => $atto->countOppAttoHasEmendamentos())) ?>
	</div>
</div>

<div class="row">
	<div class="ninecol">
		
		 
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

	            <?php $f_signers= OppAttoPeer::getRecordsetFirmatari($atto->getId(),'P'); ?>
	            <?php if ($f_signers->next()) : ?>
	                <?php if($atto->getTipoAttoId()==1 ): ?>
	                   <?php echo ' presentato da ' ?>
	                <?php else : ?>
	                   <?php echo ' di ' ?>
	                <?php endif; ?>    
	                <?php echo link_to($f_signers->getString(2).' '.$f_signers->getString(3).($f_signers->getString(6)!='' ? ' ('.$f_signers->getString(6).')' :''),'parlamentare/'.$f_signers->getInt(1)).($f_signers->next() ? ' e altri' : '') ?>
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
	        <?php if($link != '#' && $atto->getParlamentoID()!=NULL): ?>
	          <li><?php echo link_to("link alla fonte", $link, array('class' => 'external', 'target' => '_blank')) ?></li>
	        <?php endif; ?>		  
	      </ul>
	       <!-- tutto l'iter -->
	       <?php if($status): ?>
	       	    <ul class="presentation float-container" style="margin-bottom:12px;">
	               <?php include_partial('status', array('status' => $status,'atto' => $atto)) ?>
	               <?php if(count($iter_completo)!=0): ?>
		               <?php echo include_partial('iterCompleto', array('iter_completo' => $iter_completo,'atto' => $atto)) ?>
		           <?php endif; ?>
		         </ul>

		        <!-- Iter grafico per ddl e dl -->
		        <?php include_partial('statoAvanzamento', 
		                      array('atto' => $atto)) ?>

		        <!-- Pred e Succ per atti non legislativi -->
	          <?php include_partial('predSuccAttiNonLeg', 
	                	          array('atto' => $atto)) ?>                
		      <?php endif; ?>						  

	      <!-- partial per la visualizzazione e l'edit-in-place dei tags associati all'atto -->
	      <?php echo include_component('deppTagging', 'edit', array('content' => $atto)); ?>


	      <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore') && $atto->getIsOmnibus()): ?>
	        <?php echo include_component('atto', 'editTagsForIndice', array('content' => $atto)); ?>        
	      <?php endif ?>

	      <!-- component per l'elenco dei documenti -->
	      <a name="documenti"></a>
	      <?php echo include_component('atto', 'documenti', array('atto' => $atto, 'titolo_wiki' => $titolo_wiki) ); ?>


	      <!-- DESCRIZIONE -->
	      <div class="wiki-box-container">
	    	<h5 class="description" style="padding-bottom: 0px;">descrivi insieme agli altri utenti questo atto:</h5>
	    	<p style="padding-left:5px;">qui sotto puoi inserire o modificare la descrizione per questa votazione.
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
	<div class="threecol last">
		
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
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php include_partial('atto/breadcrumbsAtti', array('atto' => $atto)) ?> /
    <?php echo Text::denominazioneAttoShort($atto) ?>
<?php end_slot() ?>
