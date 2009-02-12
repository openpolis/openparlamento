<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
  * @package sfLucenePlugin
  * @subpackage Test
  * @author Carl Vondrick
  */

$app = isset($app) ? $app : 'frontend';

define('SF_ROOT_DIR', dirname(__FILE__) . '/../../../..');
define('SF_APP', $app);
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG', true);

require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

sfContext::getInstance();

error_reporting(E_ALL);

include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
require_once($sf_symfony_lib_dir.'/vendor/lime/lime.php');