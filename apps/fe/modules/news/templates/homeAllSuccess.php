<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div class="row">
	<div class="twelvecol">
		
		<h4 class="subsection">Tutte le notizie dal Parlamento<?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS', 'width' => '32', 'height' => '13')), '@feed', array('style' => 'vertical-align:middle; padding:5px;')) ?></h4>

	      <p style="padding: 5px; font-size:14px;">Ci sono <strong><?php echo $pager->getNbResults() ?></strong> notizie. Sono visualizzate cronologicamente dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>.</p>

	      <?php echo include_partial('news/newslist',array('pager' => $pager, 'context' => CONTEXT_LIST)); ?>

	      <?php echo pager_navigation($pager, '@news_home') ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    tutte le notizie dal Parlamento
<?php end_slot() ?>

