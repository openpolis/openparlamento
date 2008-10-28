<?php

// Define your test Propel class with behavior applied here
define('TEST_CLASS', 'sfTestMonitorable');

// Define a setter and a getter methods for this article, other than primary key
define('TEST_METHOD_SETTER', 'setTitle');
define('TEST_METHOD_GETTER', 'getTitle');

// Define test users
define('TEST_USER_ID', 8);
define('TEST_OTHER_USER_ID', 32);

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

$user_id = TEST_USER_ID;
$user = OppUserPeer::retrieveByPK($user_id);
$other_user_id = TEST_OTHER_USER_ID;

// start tests
$t = new lime_test(13, new lime_output_color());

$t->diag('deppPropelActAsMonitorableBehaviorPlugin API unit test');

$t->diag('Tests beginning');

// clean the database
$existing_records = sfTestMonitorablePeer::doSelect(new Criteria());
foreach ($existing_records as $rec) $rec->delete();

$t->diag('Create a test object');
$obj1 = _create_object('Primo oggetto di test');
$obj1->save();

$c = new Criteria();
$c->add(MonitoringPeer::MONITORABLE_MODEL, 'sfTestMonitorable');

$t->ok($obj1->countMonitoringUsers() == 0, 'a new object has no monitoring users.');
$t->ok($obj1->countMonitoredObjects($user_id, $c) == 0, 'the user is monitoring no objects');
$t->ok($obj1->isMonitoredByUser($user_id) == false, 'the user is not monitoring the first object');

$t->diag('Make default user monitors the object');
$obj1->addMonitoring($user_id);
$t->ok($obj1->countMonitoringUsers() == 1, 'a user is now monitoring.');
$t->ok($obj1->countMonitoredObjects($user_id, $c) == 1, 'the user is monitoring one object');
$t->ok($obj1->isMonitoredByUser($user_id) == true, 'the user is monitoring the first object');

$t->diag('Test the caches');
$t->ok($obj1->countMonitoringUsers() == $obj1->countMonitoringUsers(true), 'the cache for the number of monitoring users is working');
$t->ok($obj1->countMonitoredObjects($user_id, $c) == $obj1->countMonitoredObjects($user_id, $c, true), 'the cache for the number of monitored objects is working');
 
$t->diag('Make another user monitors the object');
$obj1->addMonitoring($other_user_id);
$t->ok($obj1->countMonitoringUsers() == 2, 'two users are now monitoring.');
$monitoring_users = $obj1->getMonitoringUsers();
foreach ($monitoring_users as $usr)
{
  $t->diag($usr->getId() . ": " . $usr->getFirstName() . " " . $usr->getLastName());
}

$t->diag('Create another object');
$obj2 = _create_object('Secondo oggetto di test');
$obj2->save();

$obj2->addMonitoring($user_id);
$t->ok($obj1->countMonitoredObjects($user_id, $c) == 2, 'the user is now monitoring two objects');

$monitored_objects = deppPropelActAsMonitorableBehavior::getMonitoredObjects($user_id, $c);
$getter = TEST_METHOD_GETTER;

foreach ($monitored_objects as $obj)
{
  $t->diag($obj->getId() . ": " . $obj->$getter());
}

$t->diag('Remove the second object (test cascading)');
$obj2->delete();
$t->ok($obj1->countMonitoredObjects($user_id, $c) == 1, 'the user is now monitoring one object again');

$t->diag('Remove the other user\'s monitor');
$obj1->removeMonitoring($other_user_id);
$t->ok($obj1->countMonitoringUsers() == 1, 'one user left now monitoring.');
$t->ok($obj1->countMonitoredObjects($user_id, $c) == 1, 'the user is always monitoring one object');


$t->diag('Remove the first  object (resetting)');
$obj1->delete();

$t->diag('Tests terminated');



// test object creation
function _create_object($string = 'Default title')
{
  $classname = TEST_CLASS;
  $method = TEST_METHOD_SETTER;
  
  if (!class_exists($classname))
  {
    throw new Exception(sprintf('Unknow class "%s"', $classname));
  }

  $obj = new $classname;
  // set a field to set the status of the object to isModified and have the doSave() function work
  $obj->$method($string);
  return $obj;
}