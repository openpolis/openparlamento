<?php
/**
 * @package sfLucenePlugin
 * @subpackage Module
 * @author Carl Vondrick <carlv@carlsoft.net>
 */
?>

<?php use_helper('sfLucene', 'I18N') ?>

<h2><?php echo __('Search Results') ?></h2>

<p><?php echo __('The following results matched your query:') ?></p>

<ol start="<?php echo $pager->getFirstIndice() ?>" class="search-results">
  <?php foreach ($pager->getResults() as $result): ?>
    <li><?php include_search_result($result, $query) ?></li>
  <?php endforeach ?>
</ol>

<?php include_search_pager($pager, sfConfig::get('app_lucene_pager_radius'), $category) ?>

<?php include_search_controls($query) ?>
