<?php

if (sfConfig::get('app_sf_guard_plugin_routes_register', true) && in_array('sfGuardAuth', sfConfig::get('sf_enabled_modules', array())))
{
  $r = sfRouting::getInstance();

  // preprend our routes
  $r->prependRoute('sf_guard_signin', '/login', array('module' => 'sfGuardAuth', 'action' => 'signin'));
  $r->prependRoute('sf_guard_signout', '/logout', array('module' => 'sfGuardAuth', 'action' => 'signout'));
  $r->prependRoute('sf_guard_password', '/request_password', array('module' => 'sfGuardAuth', 'action' => 'password'));
}
