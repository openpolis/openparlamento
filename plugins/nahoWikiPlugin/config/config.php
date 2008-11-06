<?php

// Load InterWiki config files
$interwiki_config_file = sfConfig::get('sf_app_config_dir_name').'/interwiki.yml';
require_once(sfConfigCache::getInstance()->checkConfig($interwiki_config_file)); // app_nahoWikiPlugin_interwiki

// Automatic routes
$routes_register = sfConfig::get('app_nahoWikiPlugin_routes_register', true);
$enabled_module = in_array('nahoWiki', sfConfig::get('sf_enabled_modules', array()));
if ($routes_register && $enabled_module)
{
  $r = sfRouting::getInstance();

  // preprend our routes
  $r->prependRoute('wiki_home',
    '/wiki',
    array('module' => 'nahoWiki', 'action' => 'index'));
  
  $r->prependRoute('wiki_view_revision',
    '/wiki/view/:page/:revision',
    array('module' => 'nahoWiki', 'action' => 'view'));
  
  $r->prependRoute('wiki_view',
    '/wiki/view/:page',
    array('module' => 'nahoWiki', 'action' => 'view'));
  
  $r->prependRoute('wiki_edit_revision',
    '/wiki/edit/:page/:revision',
    array('module' => 'nahoWiki', 'action' => 'edit'));
  
  $r->prependRoute('wiki_edit',
    '/wiki/edit/:page',
    array('module' => 'nahoWiki', 'action' => 'edit'));
  
  $r->prependRoute('wiki_history',
    '/wiki/history/:page',
    array('module' => 'nahoWiki', 'action' => 'history'));
  
  $r->prependRoute('wiki_diff',
    '/wiki/diff/*',
    array('module' => 'nahoWiki', 'action' => 'diff'));
  
  $r->prependRoute('wiki_index',
    '/wiki/index/*',
    array('module' => 'nahoWiki', 'action' => 'browse'));

}
