<?php use_helper('PagerNavigation', 'DeppNews') ?>
<?php setlocale(LC_TIME,"it_IT") ?>

<div class="row">
	<div class="ninecol">
		
		<h4 class="subsection">
	        Tutte le notizie su 
	        <?php echo $act->getOppTipoAtto()->getDescrizione() . ' ' . 
	                   $act->getRamo().'.'.$act->getNumfase() . ' ' . 
	                   $act->getTitolo() ?>
	        <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS', 'width' => '32', 'height' => '13')), 
	                           '@feed_atto?id='.$act_id, 
	                           array('style' => 'vertical-align:middle; padding:5px;')) ?>
	      </h4>
	      <p style="padding: 5px; font-size:14px;">
	        Ci sono <strong><?php echo $pager->getNbResults() ?></strong> notizie. 
	        Sono visualizzate cronologicamente dalla <?php echo $pager->getFirstIndice() ?> 
	        alla  <?php echo $pager->getLastIndice() ?>.</p>

	      <?php echo include_partial('news/newslist',array('pager' => $pager, 'context' => CONTEXT_ATTO)); ?>

	      <?php echo pager_navigation($pager, '@news_atto?id='.$act_id, true, 7) ?>
		
	</div>
	<div class="threecol last">
		
		<div class="section-box">
		  <h6>Collegamenti</h6>
		  <div class="float-container">
		    <ul>
		      <li><?php echo link_to('pagina dell\'atto '.$act->getRamo().'.'.$act->getNumfase(), '@singolo_atto?id='.$act_id) ?></li>
		      <?php if ($sf_user->isAuthenticated()): ?>
		        <li><?php echo link_to('DDL e Atti monitorati', 'monitoring/acts') ?></li>              
		      <?php endif ?>
		    </ul>
		  </div>
		</div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php if ($act->getTipoAttoId()==1): ?>
	<?php echo link_to("disegni di legge", "@attiDisegni") ?>
    <?php endif; ?> 
    	
    <?php if ($act->getTipoAttoId()==12): ?>
	<?php echo link_to("decreti legge", "@attiDecretiLegge") ?>
    <?php endif; ?> 
    
    <?php if ($act->getTipoAttoId()==15 || $act->getTipoAttoId()==16 || $act->getTipoAttoId()==17): ?>
	<?php echo link_to("decreti legislativi", "atto/decretoLegislativoList") ?>
    <?php endif; ?> 
    
    <?php if (($act->getTipoAttoId()<12 && $act->getTipoAttoId()!=1) || $act->getTipoAttoId()==14): ?>
	<?php echo link_to("atti non legislativi", "@attiNonLegislativi") ?>
    <?php endif; ?> 

    /
    <?php echo link_to(Text::denominazioneAttoShort($act),'@singolo_atto?id='.$act_id) ?> /
    tutte le notizie

     
<?php end_slot() ?>
