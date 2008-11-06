<div class="<?php echo sfConfig::get('app_nahoWikiPlugin_wrap_class', 'nahoWiki') ?>">

<?php include_partial('page_tools', array('uriParams' => $uriParams, 'canView' => $canView, 'canEdit' => $canEdit)) ?>

<?php include_partial('page_edit', array('page' => $page, 'revision' => $revision, 'uriParams' => $uriParams, 'userName' => $userName, 'canView' => $canView, 'canEdit' => $canEdit)) ?>

</div>