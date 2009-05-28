<?php
/*
 * This file is part of the sfEmendPlugin package.
 * 
 * (c) 2008 Guglielmo Celata <guglielmo@depp.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
// Automatic API routes
$enabled_module = in_array('sfEmendAPI', 
                           sfConfig::get('sf_enabled_modules', array()));
if ($enabled_module)
{
  $r = sfRouting::getInstance();

  // preprend our routes
  $r->prependRoute('eMend_getComments',
    '/emend.getComments/:url',
    array('module' => 'sfEmendAPI', 
          'action' => 'getComments'));
  
  $r->prependRoute('emend_addComment',
    '/emend.addComment/:url',
    array('module' => 'sfEmendAPI', 
          'action' => 'addComment'));  

  $r->prependRoute('emend_addLog',
    '/emend.addLog/*',
    array('module' => 'sfEmendAPI', 
          'action' => 'addLog'));  
}
 