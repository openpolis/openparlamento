<?php
/**
 * @package sfLucenePlugin
 * @subpackage Module
 * @author Carl Vondrick <carlv@carlsoft.net>
 */
?>

<?php use_helper('I18N') ?>
<h2><?php echo __('No Results Found') ?></h2>
<p><?php echo __('We could not find any results with the search term you provided.') ?></p>

<?php include_component($sf_context->getModuleName(), 'controls') ?>

