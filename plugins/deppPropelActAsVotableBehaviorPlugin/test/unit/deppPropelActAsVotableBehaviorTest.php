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
$t = new lime_test(28, new lime_output_color());

$t->diag('deppPropelActAsVotableBehaviorPlugin API unit test');

$t->diag('Tests beginning');

// clean the database
sfVotingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

// an object is created and a test on the countVotings and getVoting values is performed
$obj1 = _create_object();
$t->ok($obj1->countVotings() == 0, 'a new object has no votings.');
$t->ok($obj1->getVoting() == 0.0, 'a new object has an average vote of 0');
$obj1->save();

$obj2 = _create_object();
$obj2->save();

// Override any existing voting_range parameter
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_voting_range', 
            get_class($obj1)), 2);
$t->is($obj1->getVotingRange(), 2, 'getVotingRange() read the voting_range parameter (changed at runtime)');

// control if the neutral position is accepted
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_neutral_position', 
            get_class($obj1)), true);
$t->is($obj1->allowsNeutralPosition(), true, 'allowsNeutralPosition() returns if the neutral position is allowed or not');

// control if anonymous voting is accepted
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_anonymous_voting', 
            get_class($obj1)), true);
$t->is($obj1->allowsAnonymousVoting(), true, 'allowsAnonymousVoting() returns if anonymous voting is allowed or not');

// define three users
$user_1_id = 1;
$user_2_id = 4;
$user_3_id = 6;

// first user tries to express an opinion outside the voting range
try
{
  $obj1->setVoting(10, $user_1_id);
  $t->fail('setVoting() It is possible to overrate an object :(');
}
catch (Exception $e)
{
  $t->pass('setVoting() It is impossible to overrate an object');
}


// first user votes inside the voting range with a positive
try
{
  $obj1->setVoting(1, $user_1_id);
  $t->pass('setVoting() a vote inside the voting_range is accepted');
}
catch (Exception $e)
{
  $t->fail('setVoting() a vote inside the voting-range should be accepted (but it\'s not) ' . $e->getMessage());
}

// second user votes inside the voting range with a negative
try
{
  $obj1->setVoting(-2, $user_2_id);
  $t->pass('setVoting() a vote inside the voting_range is accepted');
}
catch (Exception $e)
{
  $t->fail('setVoting() a vote inside the voting-range should be accepted (but it\'s not) ' . $e->getMessage());
}

// test the countVoting() method
$t->ok($obj1->countVotings()==2, 'countVotings() counts two votes');

// test the getVoting() method (-0.5)
$t->ok($obj1->getVoting()==-0.5, 'getVoting() the average of the two votes for object one is -0.5');

// test wether objects have been voted at all
$t->ok($obj1->hasBeenVoted() == true, 'hasBeenVoted() obj1 has been voted');
$t->ok($obj2->hasBeenVoted() == false, 'hasBeenVoted() obj2 has NOT been voted');

// test wether objects have been voted by a user
$t->ok($obj1->hasBeenVotedByUser($user_1_id) == true, 'hasBeenVotedByUser() obj1 has been voted by user1');
$t->ok($obj1->hasBeenVotedByUser($user_3_id) == false, 'hasBeenVotedByUser() obj1 has NOT been voted by user3');

// test the votingDetails() function
$voting_details = $obj1->getVotingDetails();
$t->ok($voting_details[1] == 1 && !array_key_exists(-2, $voting_details), 'getVotingDetails() simple voting details for the previous votation are correctly extracted, keys out of range do not exist');
$t->ok(array_key_exists(2, $voting_details) == false, 'getVotingDetails() simple voting details do not contain keys for unexpressed opinions');

// test the votingDetails(true) method, that extracts details for all possible keys
$full_voting_details = $obj1->getVotingDetails(true);
$t->ok($voting_details[1] == 1 && $full_voting_details[-2] == 1, 'getVotingDetails() full voting details for the previous votation are correctly extracted, keys out of range do exist');
$t->ok($full_voting_details[0] == 0 && $voting_details[1] == 1, 'getVotingDetails() full voting details for the previous votation are correctly extracted');

// test the getUserVoting() method
$t->ok($obj1->getUserVoting($user_1_id) == 1, "getUserVoting() first user voted 1");
$t->ok($obj1->getUserVoting($user_2_id) == -2, "getUserVoting() second user voted -2");
// second user votes inside the voting range with a negative
try
{
  $null_user = $obj1->getUserVoting(null);
  $t->fail('getUserVoting() when a user is not passed (null), an exception should be raised');
}
catch (Exception $e)
{
  $t->pass('getUserVoting() when a user is not passed, an exception is raised');
}

// test the getReferenceKey() method
sfConfig::set(
    sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_reference_field', 
            get_class($obj1)), '');
$t->is($obj1->getReferenceKey(), $obj1->getPrimaryKey(), 'getReferenceKey() get the primary key as default');


// thest the clearUserVoting() method
$res = $obj1->clearUserVoting($user_1_id);
$t->ok($obj1->hasBeenVotedByUser($user_1_id) == false, 'clearUserVoting() remove votings of an user from an object');

// thest the clearVotings() method
$res = $obj1->clearVotings();
$t->ok($obj1->hasBeenVoted() == false, 'clearVotings() remove all votings from an object');


// anonymous vote allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_anonymous_voting', 
            get_class($obj1)), true);
try
{
  $obj1->setVoting(1);
  $t->pass('setVoting() an anonymous vote is set, when allowed');
}
catch (Exception $e)
{
  $t->fail('setVoting() an anonymous vote could not be set, even if allowed');
}

// anonymous vote not allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_anonymous_voting', 
            get_class($obj1)), false);
try
{
  $obj1->setVoting(1);
  $t->fail('setVoting() an anonymous vote is set, even if it should not');
}
catch (Exception $e)
{
  $t->pass('setVoting() an anonymous vote is NOT set, when not allowed');
}


// first user tries to express the neutral opinion, when allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_neutral_position', 
            get_class($obj1)), true);
try
{
  $obj1->setVoting(0, $user_1_id);
  $t->pass('setVoting() a neutral opinion was accepted, when allowed');
}
catch (Exception $e)
{
  $t->fail('setVoting() a neutral opinion could not be accepted, even if allowed');
}


// first user tries to express the neutral opinion, when not allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsVotableBehavior_%s_neutral_position', 
            get_class($obj1)), false);
try
{
  $obj1->setVoting(0, $user_1_id);
  $t->fail('setVoting() a neutral opinion was accepted, even when not allowed');
}
catch (Exception $e)
{
  $t->pass('setVoting() a neutral opinion is NOT accepted, when not allowed');
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
  $obj->$method('Trial value');
  return $obj;
}