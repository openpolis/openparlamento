<?php
/**
 * @package sfLucenePlugin
 * @subpackage Module
 * @author Carl Vondrick <carlv@carlsoft.net>
 */
?>

<?php use_helper('sfLucene', 'I18N', 'PagerNavigation') ?>

<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Risultati della ricerca per <i><?php echo $query ?></i></h2></li>
</ul>

<div class="tabbed float-container" id="content">
	<div id="main">
	  <div class="W100_100 float-left" style="margin-bottom: 20px">

      <p>Ci sono <?php echo $num ?> risultati per la tua ricerca</p>

      <ol start="<?php echo $pager->getFirstIndice() ?>" class="search-results">
        <?php foreach ($pager->getResults() as $result): ?>
          <li><?php include_search_result($result, $query) ?></li>
        <?php endforeach ?>
      </ol>

      <?php echo pager_navigation($pager, "@sf_lucene_search_results?query=$query") ?>


    </div>
  </div>
</div>

<?php slot('search') ?>
  <?php include_search_controls($query) ?>
<?php end_slot() ?>

<?php slot('search_breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Risultati della ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>



