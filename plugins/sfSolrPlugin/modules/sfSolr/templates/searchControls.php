<?php
/**
 * @package sfSolrPlugin
 * @subpackage Module
 * @author Guglielmo Celata <g.celata@depp.it>
 */
?>

<?php use_helper('I18N') ?>

<h2><?php echo __('Search') ?></h2>
<p><?php echo __('Use our search engine to pinpoint exactly what you need on our site.') ?></p>

<?php include_component($sf_context->getModuleName(), 'controls') ?>