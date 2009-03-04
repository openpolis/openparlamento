<?php
/**
 * @package sfLucenePlugin
 * @subpackage Module
 * @author Carl Vondrick <carlv@carlsoft.net>
 */
?>

<?php use_helper('sfLucene') ?>

<?php echo form_tag('sfLucene/search', 'method=get class=search-controls') ?>

  <label for="query"><?php echo __('What are you looking for?') ?></label>
  <?php echo input_tag('query', $query, 'accesskey=q') ?>
  <?php if (has_search_categories()): ?>
    <?php include_search_categories() ?>
  <?php endif ?>
  <?php echo submit_tag(__('Search'), 'accesskey=s') ?>
  <?php if (sfConfig::get('app_lucene_advanced', true)): ?>
    <?php echo submit_tag(__('Advanced'), 'accesskey=a') ?>
  <?php endif ?>

</form>