<div class="<?php echo sfConfig::get('app_nahoWikiPlugin_wrap_class', 'nahoWiki') ?>">

<?php include_partial('page', array('page' => $page, 'revision' => $revision, 'uriParams' => $uriParams, 'canView' => $canView, 'canEdit' => $canEdit)) ?>

</div>