<?php

// Define your test Propel class with behavior applied here
define('TEST_CLASS', 'sfTestVotable');

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
$t = new lime_test(15, new lime_output_color());

$t->diag('deppPropelActAsVotableBehaviorPlugin API unit test');

$t->diag('Tests beginning');

// clean the database
sfVotingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));


// an object is created and a test on the countVotings and getVoting values is performed
$obj = _create_object();
$t->ok($obj->countVotings() == 0, 'a new object has no votings.');
$t->ok($obj->getVoting() == 0.0, 'a new object has an average vote of 0');
$details = $obj->getVotingDetails();
print_r($details);
$t->ok(is_null($details), 'a new object has no voting details');
$obj->save();

$t->is($obj->getVotingRange(), 1, 'voting range is 1');


// define three users
$user_1_id = 1;
$user_2_id = 4;
$user_3_id = 6;

$obj->setVoting(1, $user_1_id);
$t->ok($obj->getUserVoting($user_1_id)==1, 'user 1 votes aye');
$obj->setVoting(1, $user_2_id);
$t->ok($obj->getUserVoting($user_2_id)==1, 'user 2 votes aye');
$obj->setVoting(-1, $user_3_id);
$t->ok($obj->getUserVoting($user_3_id)==-1, 'user 3 votes naw');
$t->ok($obj->countVotings() == 3, 'there were threee votes');
$voting_details = $obj->getVotingDetails();
$t->ok($voting_details[-1] == 1, 'one user was against');
$t->ok($voting_details[1]  == 2, 'two users were in favour');

$obj->clearUserVoting($user_2_id);
$t->ok($obj->countVotings() == 2, 'user 2\'s vote was nullified');
$voting_details = $obj->getVotingDetails();
$t->ok($voting_details[-1] == 1, 'one user was against');
$t->ok($voting_details[1]  == 1, 'one user was in favour');

$obj->clearVotings();
$t->ok($obj->countVotings() == 0, 'all votes were lost');
$voting_details = $obj->getVotingDetails();
$t->ok($obj->getVotingDetails() == null, 'noone ever voted');

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