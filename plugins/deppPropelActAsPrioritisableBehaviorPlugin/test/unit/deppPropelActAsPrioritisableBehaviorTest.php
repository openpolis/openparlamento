<?php

// Define your test Propel class with behavior applied here
define('TEST_CLASS', 'sfTestPrioritisable');

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

// start tests
$t = new lime_test(14, new lime_output_color());

$t->diag('deppPropelActAsPrioritisableBehaviorPlugin API unit test');

$t->diag('Tests begin');

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




// clean the database
sfPriorityPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

// an object is created and a test on the countPriorities and getPriority values is performed
$obj1 = _create_object();
$t->ok($obj1->hasBeenPrioritised() == false, 'a new object has never been prioritised.');
$t->ok($obj1->getPriorityValue() == 0, 'a new object has a priority of 0');
$obj1->save();

$obj2 = _create_object();
$obj2->save();

// Override any existing max_priority parameter
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsPrioritisableBehavior_%s_max_priority', 
            get_class($obj1)), 2);
$t->is($obj1->getMaxPriority(), 2, 'getMaxRange() read the max_priority parameter (changed at runtime)');

// control if the null priority is accepted
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsPrioritisableBehavior_%s_null_priority', 
            get_class($obj1)), true);
$t->is($obj1->allowsNullPriority(), true, 'allowsNullPriority() returns if the null priority is allowed or not');

// define three users
$user_1_id = 1;
$user_2_id = 4;
$user_3_id = 6;

// first user tries to express an opinion outside the voting range
try
{
  $obj1->setPriorityValue(3, $user_1_id);
  $t->fail('setPriorityValue() It is possible to overrate an object :(');
}
catch (Exception $e)
{
  $t->pass('setPriorityValue() It is impossible to overrate an object');
}


// first user prioritses inside the voting range with a positive
try
{
  $obj1->setPriorityValue(1, $user_1_id);
  $t->is($obj1->getPriorityValue(), 1, 'setPriority() a priority inside the max_priority is accepted');
}
catch (Exception $e)
{
  $t->fail('setPriorityValue() a priority inside the limits should be accepted (but it\'s not) ' . $e->getMessage());
}

// second user sets a null priority
try
{
  $obj1->setPriorityValue(0, $user_2_id);
  $time = date('U');
  $t->is($obj1->getPriorityValue(), 0, 'setPriority() a null priority is accepted when the allows_null_priorities params is true');
}
catch (Exception $e)
{
  $t->fail('setPriorityValue() a priority inside the voting-range should be accepted (but it\'s not) ' . $e->getMessage());
}


// test wether objects have been prioritised at all
$t->ok($obj1->hasBeenPrioritised() == true, 'hasBeenPrioritised() obj1 has been priorityd');
$t->ok($obj2->hasBeenPrioritised() == false, 'hasBeenPrioritised() obj2 has NOT been priorityd');

// test the getReferenceKey() method
sfConfig::set(
    sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_reference_field', 
            get_class($obj1)), '');
$t->is($obj1->getReferenceKey(), $obj1->getPrimaryKey(), 'getReferenceKey() get the primary key as default');


// test the getLastUser method
$t->ok($obj1->getPriorityLastUser() == $user_2_id, 'getPriorityLastUser last user that set the priority is user2');
$t->ok($obj1->getPriorityLastUpdate('U') == $time, sprintf('getPriorityLastUpdate: obj1 was last updated at %s', $obj1->getPriorityLastUpdate()));

// thest the clearPriority() method
// $res = $obj1->clearPriority();
// $t->ok($obj1->hasBeenPrioritised() == false, 'clearPriority() remove the priority from an object');


// first user tries to express the neutral opinion, when allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsPrioritisableBehavior_%s_neutral_position', 
            get_class($obj1)), true);
try
{
  $obj1->setPriorityValue(0, $user_1_id);
  $t->pass('setPriorityValue() a neutral opinion was accepted, when allowed');
}
catch (Exception $e)
{
  $t->fail('setPriorityValue() a neutral opinion could not be accepted, even if allowed');
}


// first user tries to express the null priority, when not allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsPrioritisableBehavior_%s_null_priority', 
            get_class($obj1)), false);
try
{
  $obj1->setPriorityValue(0, $user_1_id);
  $t->fail('setPriorityValue() a null p riority was accepted, even when not allowed');
}
catch (Exception $e)
{
  $t->pass('setPriorityValue() a null priority is NOT accepted, when not allowed');
}


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
  $obj->$method('Trial item');
  return $obj;
}