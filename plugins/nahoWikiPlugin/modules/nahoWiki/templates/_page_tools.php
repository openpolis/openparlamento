<?php
  use_helper('I18N');
  if (!isset($include_actions_slot)) {
    $include_actions_slot = sfConfig::get('app_nahoWikiPlugin_include_actions', true);
  }
  if (!isset($include_breadcrumbs_slot)) {
    $include_breadcrumbs_slot = sfConfig::get('app_nahoWikiPlugin_include_breadcrumbs', true);
  }
?>


<?php slot('wiki_page_actions') ?>
  <?php $action = sfContext::getInstance()->getActionName() ?>
  <?php include_partial('page_actions', array('action' => $action, 'uriParams' => $uriParams, 'canView' => $canView, 'canEdit' => $canEdit)) ?>
<?php end_slot() ?>
<?php if ($include_actions_slot) include_slot('wiki_page_actions') ?>


<?php slot('wiki_breadcrumbs') ?>
  <?php $breadcrumbs = $sf_user->getAttribute('breadcrumbs', array(), 'nahoWiki') ?>
  <?php $breadcrumbs_separator = sfConfig::get('app_nahoWikiPlugin_breadcrumbs_separator', ' » ') ?>
  <?php include_partial('breadcrumbs', array('breadcrumbs' => $breadcrumbs, 'breadcrumbs_separator' => $breadcrumbs_separator)) ?>
<?php end_slot() ?>
<?php if ($include_breadcrumbs_slot) include_slot('wiki_breadcrumbs') ?>
