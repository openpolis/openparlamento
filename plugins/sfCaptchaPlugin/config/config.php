<?php

if (sfConfig::get('app_sfGuardPlugin_routes_register', true) && in_array('sfGuardAuth', sfConfig::get('sf_enabled_modules')))
{
  $r = sfRouting::getInstance();

  // preprend our routes
  $r->prependRoute('sf_captcha', '/captcha', array('module' => 'sfCaptcha', 'action' => 'index'));
}
