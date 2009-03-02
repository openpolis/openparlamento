<?php use_helper('I18N') ?>


<?php if (!$canView): ?>
  <p class="wiki-warning"><?php echo __('You are not allowed to access this page.') ?></p>
<?php else: ?>

  <?php if (!$revision->isLatest()): ?>
    <p class="wiki-warning"><?php echo __('Stai vedendo una vecchia versione della pagina.') ?> <br /><?php echo link_to(__('Per leggere la versione corrente clicca qui'), 'nahoWiki/view?page=' . $page->getName()) ?></p>
  <?php endif ?>

  <?php include_partial('content', array('preview' => false, 'revision' => $revision, 'no_article' => $page->isNew(), 'uriParams' => $uriParams, 'hide_toc' => !sfConfig::get('app_nahoWikiPlugin_include_toc', true))) ?>

<?php endif ?>