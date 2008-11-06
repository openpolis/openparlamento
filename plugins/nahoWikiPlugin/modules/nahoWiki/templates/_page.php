<?php use_helper('I18N') ?>

<?php include_partial('page_tools', array('uriParams' => $uriParams, 'canView' => $canView, 'canEdit' => $canEdit)) ?>

<?php if (!$canView): ?>
  <p class="wiki-warning"><?php echo __('You are not allowed to access this page.') ?></p>
<?php else: ?>

  <?php if (!$revision->isLatest()): ?>
    <p class="wiki-warning"><?php echo __('You are currently viewing an old revision of this page.') ?> <?php echo link_to(__('Don\'t you want to see the latest version of this page ?'), 'nahoWiki/view?page=' . $page->getName()) ?></p>
  <?php endif ?>

  <?php include_partial('content', array('preview' => false, 'revision' => $revision, 'no_article' => $page->isNew(), 'uriParams' => $uriParams, 'hide_toc' => !sfConfig::get('app_nahoWikiPlugin_include_toc', true))) ?>

<?php endif ?>