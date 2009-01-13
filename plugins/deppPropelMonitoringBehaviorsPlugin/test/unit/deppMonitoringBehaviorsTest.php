<?php

// Define your test Propel classes with behaviors applied
define('TEST_MONITORABLE', 'sfTestMonitorable');
define('TEST_MONITORER', 'OppUser');
define('TEST_GENERATOR', 'sfTestGenerator');


// Define a setter and a getter methods for the monitorable, other than primary key
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

if (!defined('TEST_MONITORABLE') or !class_exists(TEST_MONITORABLE))
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
$other_user_id = TEST_OTHER_USER_ID;
$monitorer_callable = array(TEST_MONITORER.'Peer', 'retrieveByPK');



// start tests
$t = new lime_test(16, new lime_output_color());

$t->diag('deppMonitoringBehaviorsPlugin API unit test');

$t->diag('Tests beginning');


// clean the database
$monitorable_callable = array(TEST_MONITORABLE.'Peer', 'doSelect');
$c = new Criteria();
$c->add(MonitoringPeer::MONITORABLE_MODEL, 'sfTestMonitorable');
$existing_records = sfTestMonitorablePeer::doSelect($c);
foreach ($existing_records as $rec) 
{
  $rec->delete();
}


$t->diag('Create a test object');
$obj1 = _create_object('Primo oggetto di test', TEST_MONITORABLE);
$obj1->save();

$user = call_user_func_array($monitorer_callable, $user_id);

$t->ok($obj1->countMonitoringUsers() == 0, 'a new object has no monitoring users.');
$t->ok($user->countMonitoredObjects(TEST_MONITORABLE) == 0, 'the user is monitoring no objects.');
$t->ok($obj1->isMonitoredByUser($user_id) == false, 'the user is not monitoring the first object');
$t->ok($user->isMonitoring(TEST_MONITORABLE, $obj1->getPrimaryKey()) == false, 'same test, from the user perspective');


$t->diag('Make default user monitors the object');
$obj1->addMonitoringUser($user_id);
$t->ok($obj1->countMonitoringUsers() == 1, 'a user is now monitoring.');

// once a change is made in the cache (through the addMonitoring)
// the old user object must be destroyed and recreated, 
// otherwise, no select is ever done and the values are taken from the original user
unset($user);
$user = call_user_func_array($monitorer_callable, $user_id);


$t->ok($user->countMonitoredObjects(TEST_MONITORABLE) == 1, 'the user is monitoring one object');
$t->ok($obj1->isMonitoredByUser($user_id) == true, 'the user is monitoring the first object');
$t->ok($user->isMonitoring(TEST_MONITORABLE, $obj1->getPrimaryKey()) == true, 'same test, from the user perspective');

$t->diag('Test the caches');
$t->ok($obj1->countMonitoringUsers() == $obj1->countMonitoringUsers(true), 'the cache for the number of monitoring users is working');
$t->ok($user->countMonitoredObjects(TEST_MONITORABLE) == $user->countMonitoredObjects(TEST_MONITORABLE, null, true), 'the cache for the number of monitored objects is working');
 

$t->diag('Make another user monitors the object');
$obj1->addMonitoringUser($other_user_id);
$t->ok($obj1->countMonitoringUsers() == 2, 'two users are now monitoring.');
$monitoring_users = $obj1->getMonitoringUsers();
foreach ($monitoring_users as $usr)
{
  $t->diag($usr->getId() . ": " . $usr->getFirstName() . " " . $usr->getLastName());
}


$t->diag('Create another object');
$obj2 = _create_object('Secondo oggetto di test', TEST_MONITORABLE);
$obj2->save();

$t->diag('Add monitoring from the user\'s perspective');
$user->addMonitoredObject(get_class($obj2), $obj2->getId());

unset($user);
$user = call_user_func_array($monitorer_callable, $user_id);

$t->ok($user->countMonitoredObjects(TEST_MONITORABLE) == 2, 'the user is now monitoring two objects');

$monitored_objects = $user->getMonitoredObjects(TEST_MONITORABLE);
$getter = TEST_METHOD_GETTER;
foreach ($monitored_objects as $obj)
{
  $t->diag($obj->getId() . ": " . $obj->$getter());
}
$t->diag('Remove the second object (test cascading)');
$obj2->delete();

unset($user);
$user = call_user_func_array($monitorer_callable, $user_id);

$t->ok($user->countMonitoredObjects(TEST_MONITORABLE) == 1, 'the user is now monitoring one object again');

$t->diag('Remove the other user\'s monitor');
$obj1->removeMonitoringUser($other_user_id);
$t->ok($obj1->countMonitoringUsers() == 1, 'one user left now monitoring.');

unset($user);
$user = call_user_func_array($monitorer_callable, $user_id);

$t->ok($user->countMonitoredObjects(TEST_MONITORABLE) == 1, 'the user is always monitoring one object');




// test news generators
$t->diag('Create a generator object');
$obj3 = _create_object('Generatore di test', TEST_GENERATOR);
$obj3->setMonitorableId($obj1->getPrimaryKey());
$obj3->setTestDate('2008-11-02');
$obj3->save();

$generated_news = $obj3->getGeneratedNews();
$t->ok(count($generated_news) == 1, "One news was generated");
$single_news = $generated_news[0];

$t->diag("Data: " . $single_news->getDate());
$t->diag("Priority: " . $single_news->getPriority());

$t->diag('Remove the first  object (resetting)');
$obj1->delete();

$t->diag('Remove the generator  object (news should be removed, too)');
$obj3->delete();

$t->diag('Tests terminated');



// test objects creation
function _create_object($string = 'Default title', $classname = TEST_MONITORABLE)
{
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

