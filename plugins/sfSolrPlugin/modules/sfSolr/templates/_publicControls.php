<?php
/**
 * @package sfLucenePlugin
 * @subpackage Module
 * @author Carl Vondrick <carlv@carlsoft.net>
 */
?>

<?php use_helper('I18N') ?>

<div id="search-public">
  <?php echo form_tag('sfLucene/search', 'method=get') ?>
    <?php echo input_tag('query', $query, array('id' => 'query-public')) ?>
    <?php echo submit_tag(__('Search'), array('name' => null)) ?>
  </form>
</div>