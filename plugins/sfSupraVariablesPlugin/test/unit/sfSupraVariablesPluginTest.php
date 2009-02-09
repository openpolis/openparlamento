<?php
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'test');
define('SF_DEBUG',       true);

// initializes testing framework
$sf_root_dir = realpath(dirname(__FILE__).'/../../../../');
$apps_dir = glob($sf_root_dir.'/apps/*', GLOB_ONLYDIR);
$app = substr($apps_dir[0],
              strrpos($apps_dir[0], DIRECTORY_SEPARATOR) + 1,
              strlen($apps_dir[0]));
if (!$app)
{
  throw new Exception('No app has been detected in this project');
}

require_once($sf_root_dir.'/test/bootstrap/unit.php');
require_once($sf_symfony_lib_dir.'/vendor/lime/lime.php');
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$t = new lime_test(11, new lime_output_color());

$t->diag('unit test to verify the SupraVariables plugin');

$t->diag('Test a string');
sfSupra::setVariable('prova', 'pippo');
$prova = sfSupra::getVariable('prova');
$t->ok(is_string($prova), 'a string was stored');
$t->ok($prova == 'pippo', 'the correct value was retrieved');

$t->diag('Test an integer');
sfSupra::setVariable('a', 123);
$a = sfSupra::getVariable('a');
$t->ok(is_int($a), 'an integer was stored');
$t->ok($a == 123, 'the correct value was retrieved');

$t->diag('Test a float and overwriting');
sfSupra::setVariable('a', 123.5);
$a = sfSupra::getVariable('a');
$t->ok(is_float($a), 'a float was stored');
$t->ok($a == 123.5, 'the correct value was retrieved');

$t->diag('Test booleans');
sfSupra::setVariable('b', true);
sfSupra::setVariable('c', false);
$b = sfSupra::getVariable('b');
$c = sfSupra::getVariable('c');
$t->ok(is_bool($b) && is_bool($c), 'boolean s were stored');
$t->ok($b == true && $c == false, 'the correct values were retrieved');

$t->diag('Test complex variables');
sfSupra::setVariable('o', array("one" => 5, "two" => 7));
$o = sfSupra::getVariable('o');
$t->ok(is_array($o), 'an array was stored');
$t->ok(count($o) == 2, 'the length of the array is 2');
$t->ok($o['one'] == 5 && $o['two'] == 7, 'the corrected values were retrieved');
