<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

// limits access to users coming from localhost (dev machines or users havink the valid key)
$key = @$_GET['devkey'];
if(!in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')) ||
   deppApiKeysPeer::isValidInternalKey($key)) 
{
  sfContext::getInstance()->getController()->dispatch();  
} else {
  die("Access is only granted with keys in here!");
}
