<?php use_helper('Date', 'I18N', 'Slugger') ?>

<?php include_partial('tabs', array('emendamento' => $emendamento, 'current' => 'emendamento', 
                                    'nb_comments' => $emendamento->getNbPublicComments())) ?>

<div class="row">
	<div class="ninecol">
		
		<span style="color: rgb(136, 136, 136); font-size: 16px; font-weight: bolder;">
	      <?php if ($emendamento->getTipologia()): ?>
	        <?php echo $emendamento->getTipologia() ?>
	      <?php endif ?>
	      <?php echo "n. ".$emendamento->getNumfase() ?>
	      <?php if(count($em_portante)>0) :?>
	        <?php echo " dell'emendamento ".link_to($em_portante[0]->getNumfase(),'/emendamento/'.$em_portante[0]->getId())?>
	       <?php endif ?>  
	      <?php echo (count($relatedAttos)==1 ?' al ddl ' : 'ai ddl ') ?>
	      <?php foreach ($relatedAttos as $cnt => $atto_em): ?>
	        <?php $atto = $atto_em->getOppAtto() ?>
	        <?php echo ($cnt>0 ?', ':'').link_to($atto->getRamo().'.'.$atto->getNumfase(), '@singolo_atto?id='.$atto->getId(), array('title' => $atto->getTitolo())) ?>
	      <?php endforeach ?>
	      <?php if ($emendamento->getArticolo()) {
	        echo "in riferimento all'articolo ".$emendamento->getArticolo().".";
	      }?>
	      </span>
	        <?php if ($emendamento->getTitoloAggiuntivo()): ?>
	            <p class="synopsis">[<?php echo $emendamento->getTitoloAggiuntivo() ?>]</p>        
	        <?php endif ?>

	        <?php if ($emendamento->getDataPres()): ?>
	        <ul style="margin-bottom: 12px; margin-top: 12px;" class="presentation float-container">
	          <li><h6>presentato il <em><?php echo format_date($emendamento->getDataPres(), 'dd/MM/yyyy') ?></em>
	          in <em><?php echo $emendamento->getOppSede()->getDenominazione() ?><?php echo ($emendamento->getOppSede()->getRamo()=='C'?' della Camera':' del Senato') ?></em>
	           <?php $f_signers= OppEmendamentoPeer::getRecordsetFirmatari($emendamento->getId(),'P'); ?>

	            <?php if ($f_signers->next()) :?>  
	                 <?php echo ' da '.link_to($f_signers->getString(2).' '.$f_signers->getString(3).($f_signers->getString(6)!='' ? ' ('.$f_signers->getString(6).')' :''),'@parlamentare?id='.$f_signers->getInt(1).'&slug='.slugify($f_signers->getString(2).' '.$f_signers->getString(3))).($f_signers->next() ? ' e altri' : '') ?>
	            <?php else :?>
	              <?php if ($emendamento->getNota()) : ?>
	                 <?php if ($emendamento->getNota()=='commissione') echo 'dalla' ?>
	                 <?php if ($emendamento->getNota()=='governo') echo 'dal' ?>
	                 <?php if (preg_match('#^commissioni#',$emendamento->getNota())) echo 'dalle' ?>
	                 <?php if ($emendamento->getNota()=='relatori') echo 'dai' ?>
	                 <em>
	               <?php echo ucfirst($emendamento->getNota()) ?>.
	               </em>
	              <?php endif ?>        
	            <?php endif ?>
	            <?php $c_signers= OppEmendamentoPeer::doSelectCoFirmatari($emendamento->getId()); ?>
	            <?php if (count($c_signers)>0) : ?>
	            <span style="margin-bottom: 0px; font-size:13px; font-weight:normal">e altri <?php echo count($c_signers) ?> cofirmatari ... [ <a class="btn-open action" href="#" style="display: inline;">apri</a> <a style="display: none;" class="btn-close action" href="#">chiudi</a> ]</span>
	              <div style="display: none; line-height:1.2em;font-size:13px; font-weight:normal;" class="more-results float-container">
	              <?php 
	              $i=0;
	              foreach ($c_signers as $key => $cf) 
	              {
	                $i++;
	                $pol = OppPoliticoPeer::retrieveByPk($key);
	                echo link_to($pol->getNome()." ".$pol->getCognome(),'@parlamentare?'.$pol->getUrlParams()).($i<count($c_signers) ? ', ' :'.');
	               } ?>
	               </div>

	             <?php endif; ?>


	          </h6></li></ul>                  
	        <?php endif ?>

	         <ul style="margin-bottom: 12px; margin-top: 12px;" class="presentation float-container">
	        <li><?php echo link_to('link alla fonte',$emendamento->getUrlFonte(), array('class' => 'external'))?></li>
	        </ul>

	        <!-- STATUS --> 
	         <?php $last_status = $emendamento->getLastStatus(); ?>
	         <?php if ($last_status) : ?>
	           <?php include_partial('status', array('last_status' => $last_status,
	                                 'relatedAttos'=> $relatedAttos)); ?>
	         <?php endif; ?>

	      <!-- partial per la visualizzazione e l'edit-in-place dei tags associati all'atto -->
	      <?php echo include_component('deppTagging', 'edit', array('content' => $emendamento)); ?>

	      <br/>

	      <!-- DESCRIZIONE -->
	      <div class="wiki-box-container">
	      	<h5 class="description" style="padding-bottom: 0px;">descrivi insieme agli altri utenti questo emendamento:</h5>
	      	<p style="padding-left:5px;">qui sotto puoi inserire o modificare la descrizione.
	        	<?php if ($sf_user->isAuthenticated()) : ?>
	        	   <?php echo 'Clicca su "modifica"' ?>
	        	<?php else : ?>
	        	   Per modificare <?php echo link_to('effettua il login', '@sf_guard_signin') ?> 
	        	<?php endif ?>     
	      	</p>

	        <!-- partial per la descrizione wiki -->	
	        <?php echo include_component('nahoWiki', 'showContent', array('page_name' => 'emendamento_' . $emendamento->getId() )) ?>
	      </div>
		  <div class="row">
		  	<div class="twelvecol">
		
		  		<!-- testo dell'emendamento -->
		  	      <?php foreach ($emendamento->getOppEmTestos() as $cnt => $text): ?>
		  	      <div class="coo-mind float-container">
		  	        <h4 class="subsection"><?php echo $text->getTitolo()." del ".format_date($text->getData(),'dd/MM/yy') ?></h4>
		  	          <div style="margin:5px;"><?php echo $text->getTesto() ?></div>        
		  	      </div>
		  	      <?php endforeach ?>
		
		  	</div>
		  </div>
		
	</div>
	<div class="threecol last">
		
		<?php echo include_partial('emendamento/vote', array('emendamento' => $emendamento, 'attoPortante' => $attoPortante, 'subEmendamenti' => $subEmendamenti)); ?>
		
	</div>
	
</div>



<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php include_partial('atto/breadcrumbsAtti', array('atto' => $attoPortante)) ?> /
    <?php echo link_to(Text::denominazioneAttoShort($attoPortante), '@singolo_atto?id=' . $attoPortante->getId() ) ?> /
    <?php echo link_to('Emendamenti', '@emendamenti_atto?id='.$attoPortante->getId()) ?> /
    Emendamento <?php echo $emendamento->getTitolo() ?>
<?php end_slot() ?>
