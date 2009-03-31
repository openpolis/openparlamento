<?php

// Define your test Propel class with behavior applied here
define('TEST_CLASS', 'sfTestLaunchable');

// Define a setter and a getter methods for this article, other than primary key
define('TEST_METHOD_SETTER', 'setTitle');
define('TEST_METHOD_GETTER', 'getTitle');

// Autofind the first available app environment
$sf_root_dir = realpath(dirname(__FILE__).'/../../../../');
$apps_dir = glob($sf_root_dir.'/apps/*', GLOB_ONLYDIR);
$app = substr($apps_dir[0], 
              strrpos($apps_dir[0], DIRECTORY_SEPARATOR) + 1, 
              strlen($apps_dir[0]));
if (!$app)
{
  throw new Exception('No app has been detected in this project');
}

// Symfony test env bootstrap
require_once($sf_root_dir.'/test/bootstrap/functional.php');
require_once($sf_symfony_lib_dir.'/vendor/lime/lime.php');

if (!defined('TEST_CLASS') or !class_exists(TEST_CLASS))
{
  // Don't run tests
  return;
}

// initialize database manager
try
{
  $databaseManager = new sfDatabaseManager();
  $databaseManager->initialize();
  $con = Propel::getConnection();
}
catch (PropelException $e)
{
  $t->fail($e->getMessage());
  return 0;
}

$method_getter = TEST_METHOD_GETTER;
$method_setter = TEST_METHOD_SETTER;


// start tests
$t = new lime_test(22, new lime_output_color());

$t->diag('deppPropelActAsLaunchableBehaviorPlugin API unit test');

$t->diag('Tests beginning');

// cleanup the DB 
// remove all objects of type TEST_CLASS, and, 
// by CASCADE-emulation all the records in sf_launchings
$test_recs = call_user_func(array(_create_object()->getPeer(), 'doSelect'), new Criteria());
foreach ($test_recs as $test_rec) {
  $test_rec->delete();
}

// an object is created and a test on the countLaunchings and getLaunching values is performed
$obj1 = _create_object();
$t->ok($obj1->countPositiveLaunchings() == 0, 'countPositiveLaunchings() - a new object has no positive launchings.');
$t->ok($obj1->countNegativeLaunchings() == 0, 'countNegativeLaunchings() - a new object has no negative launchings.');
$obj1->save();


// define three users
$user_1_id = 1;
$user_2_id = 4;
$user_3_id = 6;

$t->diag("Object1 is launched by user1 and user2, positively and negatively resp.");

// first user launchs the first object positively
try
{
  $obj1->setPositiveLaunching($user_1_id);
  $t->pass('setPositiveLaunching() obj1 was positively launched by user1');
}
catch (Exception $e)
{
  $t->fail('setPositiveLaunching() obj1 could not be positively launched by user1 ' . $e->getMessage());
}
$t->ok($obj1->countPositiveLaunchings() == 1, 'countPositiveLaunchings() - obj1 has one positive launching.');

// second user launchs the first object negatively
try
{
  $obj1->setNegativeLaunching($user_2_id);
  $t->pass('setNegativeLaunching() obj2 was negatively launched by user2');
}
catch (Exception $e)
{
  $t->fail('setNegativeLaunching() obj1 could not be negatively launched by user2 ' . $e->getMessage());
}
$t->ok($obj1->countNegativeLaunchings() == 1, 'countNegativeLaunchings() - obj1 has one negative launching.');


$t->diag("User3 launchs negatively object1, then remove the launching");
$obj1->setNegativeLaunching($user_3_id);
$t->ok($obj1->countNegativeLaunchings() == 2, 'countNegativeLaunchings() - obj1 has two negative launchings.');
// second user launchs the first object negatively
try
{
  $obj1->removeNegativeLaunching($user_3_id);
  $t->pass('removeNegativeLaunching() - a negative launch on obj1 was removed by user3');
}
catch (Exception $e)
{
  $t->fail('removeNegativeLaunching() - a negative launch on obj1 could not be removed by user3');
}
$t->ok($obj1->countNegativeLaunchings() == 1, 'countNegativeLaunchings() - obj1 has one negative launching.');

$t->ok($obj1->hasBeenPositivelyLaunched($user_1_id) == true, 'hasBeenPositivelyLaunched() - obj1 was positively launched by user 1');
$t->ok($obj1->hasBeenNegativelyLaunched($user_1_id) == false, 'hasBeenNegativelyLaunched() - obj1 was NOT negatively launched by user 1');
$t->ok($obj1->hasBeenPositivelyLaunched($user_2_id) == false, 'hasBeenPositivelyLaunched() - obj1 was NOT positively launched by user 1');
$t->ok($obj1->hasBeenNegativelyLaunched($user_2_id) == true, 'hasBeenNegativelyLaunched() - obj1 was negatively launched by user 1');
$t->ok($obj1->hasBeenNegativelyLaunched($user_3_id) == false, 'hasBeenNegativelyLaunched() - obj1 was NOT negatively launched by user 1');


$t->diag('List of launched objects');
$launched_ids = sfLaunchingPeer::getAllPositivelyLaunchedIds($user_1_id);
$t->ok($launched_ids[TEST_CLASS][0] == $obj1->getId(), 'sfLaunchingPeer::getAllPositivelyLaunchedIds() - is working');
$launched_ids = sfLaunchingPeer::getAllPositivelyLaunchedIds($user_2_id);
$t->ok($launched_ids == array(), 'sfLaunchingPeer::getAllPositivelyLaunchedIds() - empty case scenario');

$launched_ids = sfLaunchingPeer::getAllNegativelyLaunchedIds($user_2_id);
$t->ok($launched_ids[TEST_CLASS][0] == $obj1->getId(), 'sfLaunchingPeer::getAllNegativelyLaunchedIds() - is working');
$launched_ids = sfLaunchingPeer::getAllNegativelyLaunchedIds($user_1_id);
$t->ok($launched_ids == array(), 'sfLaunchingPeer::getAllNegativelyLaunchedIds() - empty case scenario');

$launched_objs = sfLaunchingPeer::getAllPositivelyLaunched($user_1_id);
$t->ok($launched_objs[0] == $obj1, 'sfLaunchingPeer::getAllPositivelyLaunched() - is working');

$launched_objs = sfLaunchingPeer::getAllNegativelyLaunched($user_2_id);
$t->ok($launched_objs[0] == $obj1, 'sfLaunchingPeer::getAllNegativelyLaunched() - is working');

$launched_objs = sfLaunchingPeer::getAllPositivelyLaunched($user_2_id);
$t->ok($launched_objs == array(), 'sfLaunchingPeer::getAllPositivelyLaunched() - empty case');

$t->diag('List of some toolkit methods');
$t->ok(deppPropelActAsLaunchableToolkit::isLaunchable(TEST_CLASS) == true,
       'deppPropelActAsLaunchableToolkit::isLaunchable() - is working');

$t->diag('Tests terminated');



// test object creation
function _create_object()
{
  $classname = TEST_CLASS;
  $method = TEST_METHOD_SETTER;
  
  if (!class_exists($classname))
  {
    throw new Exception(sprintf('Unknow class "%s"', $classname));
  }

  $obj = new $classname;
  // set a field to set the status of the object to isModified and have the doSave() function work
  $obj->$method('Trial value');
  return $obj;
}