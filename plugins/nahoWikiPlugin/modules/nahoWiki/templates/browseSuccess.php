<?php use_helper('nahoWiki') ?>
<div class="<?php echo sfConfig::get('app_nahoWikiPlugin_wrap_class', 'nahoWiki') ?>">

<?php include_partial('page_tools', array('uriParams' => $uriParams, 'canView' => $canView, 'canEdit' => $canEdit)) ?>

<h1 class="wiki-title"><?php echo __('Index by title') ?></h1>

<div class="wiki-index">
	<p><?php echo __('All the pages of the wiki are listed here, sorted by category and name.') ?></p>
  <?php include_partial('index', array('tree' => $tree, 'base' => '', 'uriParams' => $uriParams)) ?>
</div>

</div>