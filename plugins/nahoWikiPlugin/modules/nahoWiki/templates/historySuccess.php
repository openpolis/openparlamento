<div class="<?php echo sfConfig::get('app_nahoWikiPlugin_wrap_class', 'nahoWiki') ?>">

<?php include_partial('page_tools', array('uriParams' => 'page=' . urlencode($page->getName()), 'canView' => $canView, 'canEdit' => $canEdit)) ?>

<?php include_partial('page_history', array('page' => $page, 'compare' => count($page->getRevisions()) > 1, 'canView' => $canView, 'canEdit' => $canEdit)) ?>

</div>