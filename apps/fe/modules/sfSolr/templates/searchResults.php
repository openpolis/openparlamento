<?php
/**
 * @package sfSolrPlugin
 * @subpackage Module
 * @author     Guglielmo Celata <g.celata@depp.it>
 */
?>

<?php use_helper('sfSolr', 'I18N', 'PagerNavigation') ?>

<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Risultati della ricerca per <i><?php echo $query ?></i></h2></li>
</ul>


<div class="tabbed float-container" id="content">
	<div id="main">
	  <div class="W100_100 float-left" style="margin-bottom: 20px">

      <p style="margin: 10px 0; text-align: right; padding: 10px">Risultati <?php echo $start ?> - <?php echo $start + $rows - 1 ?> su 
         <?php echo $num ?> per <strong><?php echo $query ?></strong> (<?php echo $qTime ?>ms)</p>

      <ol start="<?php echo $pager->getFirstIndice() ?>" class="search-results">
        <?php foreach ($pager->getResults() as $result): ?>
          <li><?php include_search_result($result, $query) ?></li>
        <?php endforeach ?>
      </ol>

      <?php echo pager_navigation($pager, "@sf_solr_search_results?query=$query") ?>


    </div>
  </div>
</div>

<?php slot('search') ?>
  <?php include_search_controls($query) ?>
<?php end_slot() ?>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>



