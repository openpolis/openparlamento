<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div class="row">
	<div class="ninecol">
		
		<h4 class="subsection">Tutte le notizie relative ai decreti legislativi<?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS', 'width' => '32', 'height' => '13')), '@feed_decretiLegislativi', array('style' => 'vertical-align:middle; padding:5px;')) ?></h4>
	      <?php include_partial('filter',
	                          array('selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>
	      <p style="padding: 5px; font-size:14px;">Ci sono <strong><?php echo $pager->getNbResults() ?></strong> notizie. Sono visualizzate cronologicamente dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>.</p>

	      <?php echo include_partial('news/newslist',array('pager' => $pager, 'context' => CONTEXT_LIST)); ?>

	       <?php echo pager_navigation($pager, 'news/decretiLegislativiList') ?>
		
	</div>
	<div class="threecol last">
		
		<div class="section-box">
	        <h6>Collegamenti</h6>
	        <div class="float-container">
	          <ul>
	            <li><?php echo link_to('Lista dei decreti legislativi', '@attiDecretiLegislativi') ?></li>
	          </ul>
	        </div>
	      </div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
    <?php echo link_to("decreti legislativi", "atto/decretoLegislativoList") ?> /
   tutte le notizie
<?php end_slot() ?>
