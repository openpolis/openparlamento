<?php use_helper('PagerNavigation', 'DeppNews') ?>
<?php setlocale(LC_TIME,"it_IT") ?>

<div class="row">
	<div class="ninecol">
		
		<h4 class="subsection">Tutte le notizie relative
	        <?php if ($carica) : ?>
	          <?php if($carica->getTipoCaricaId() !=1 ): ?>
	            <?php echo " al Sen. " ?>
	          <?php else: ?>
	            <?php echo " all'On. " ?>
	          <?php endif; ?> 
	        <?php endif; ?>   
	        <?php echo $politician ?>          
	        <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), 
	                           '@feed_politico?id='.$politician_id, 
	                           array('style' => 'vertical-align:middle; padding:5px;')) ?>
	      </h4>
	      <p style="padding: 5px; font-size:14px;">
	        Ci sono <strong><?php echo $pager->getNbResults() ?></strong> notizie. 
	        Sono visualizzate cronologicamente dalla <?php echo $pager->getFirstIndice() ?> 
	        alla  <?php echo $pager->getLastIndice() ?>.</p>

	      <?php echo include_partial('news/newslist', array('pager' => $pager, 'context' => CONTEXT_POLITICO)); ?>

	      <?php echo pager_navigation($pager, '@news_parlamentare?id='.$politician_id, true, 7) ?>
		
	</div>
	<div class="threecol last">
		
		<div class="section-box">
	        <h6>Collegamenti</h6>
	        <div class="float-container">
	          <ul>
	            <li><?php echo link_to('pagina di ' . $politician, '@parlamentare?id='.$politician_id) ?></li>
	            <?php if ($sf_user->isAuthenticated()): ?>
	              <li><?php echo link_to('i parlamentari monitorati', 'monitoring/politicians') ?></li>              
	            <?php endif ?>
	          </ul>
	        </div>
	      </div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php if ($carica) : ?>
   <?php if($carica->getTipoCaricaId() !=1 ): ?>
    <?php echo link_to('senatori', '@parlamentari?ramo=senato') ?> /
    Sen. 
   <?php else: ?>
    <?php echo link_to('deputati', '@parlamentari?ramo=camera') ?> /
    On.
   <?php endif; ?>
   <?php endif; ?> 
  <?php echo link_to($politician,'@parlamentare?id='.$politician_id) ?> /
   tutte le notizie
<?php end_slot() ?>