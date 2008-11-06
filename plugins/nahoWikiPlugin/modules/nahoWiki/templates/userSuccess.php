<?php use_helper('I18N') ?>
<div class="<?php echo sfConfig::get('app_nahoWikiPlugin_wrap_class', 'nahoWiki') ?>">

<?php slot('wiki_page_header') ?>
  <p><?php echo __('This is the personal page of an author. You will find here information about the user.') ?></p>
<?php end_slot() ?>

<?php include_partial('page', array('page' => $page, 'revision' => $revision, 'uriParams' => $uriParams, 'canView' => $canView, 'canEdit' => $canEdit)) ?>

</div>