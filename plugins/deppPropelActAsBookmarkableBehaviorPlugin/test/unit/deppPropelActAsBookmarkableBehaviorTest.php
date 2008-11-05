<?php

// Define your test Propel class with behavior applied here
define('TEST_CLASS', 'sfTestBookmarkable');

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
$t = new lime_test(27, new lime_output_color());

$t->diag('deppPropelActAsBookmarkableBehaviorPlugin API unit test');

$t->diag('Tests beginning');

// clean the database
sfBookmarkingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));


// an object is created and a test on the countBookmarkings and getBookmarking values is performed
$obj1 = _create_object();
$t->ok($obj1->countBookmarkings() == 0, 'a new object has no bookmarkings.');
$t->ok($obj1->getBookmarking() == 0.0, 'a new object has an average bookmark of 0');
$obj1->save();


$obj2 = _create_object();
$obj2->save();


// Override any existing bookmarking_range parameter
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsBookmarkableBehavior_%s_bookmarking_range', 
            get_class($obj1)), 2);
$t->is($obj1->getBookmarkingRange(), 2, 'getBookmarkingRange() read the bookmarking_range parameter (changed at runtime)');

// control if the neutral position is accepted
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsBookmarkableBehavior_%s_neutral_position', 
            get_class($obj1)), true);
$t->is($obj1->allowsNeutralPosition(), true, 'allowsNeutralPosition() returns if the neutral position is allowed or not');

// control if anonymous bookmarking is accepted
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsBookmarkableBehavior_%s_anonymous_bookmarking', 
            get_class($obj1)), true);
$t->is($obj1->allowsAnonymousBookmarking(), true, 'allowsAnonymousBookmarking() returns if anonymous bookmarking is allowed or not');


// define three users
$user_1_id = 1;
$user_2_id = 4;
$user_3_id = 6;

// first user tries to express an opinion outside the bookmarking range
try
{
  $obj1->setBookmarking(10, $user_1_id);
  $t->fail('setBookmarking() It is possible to overrate an object :(');
}
catch (Exception $e)
{
  $t->pass('setBookmarking() It is impossible to overrate an object');
}


// first user bookmarks inside the bookmarking range with a positive
try
{
  $obj1->setBookmarking(1, $user_1_id);
  $t->pass('setBookmarking() a bookmark inside the bookmarking_range is accepted');
}
catch (Exception $e)
{
  $t->fail('setBookmarking() a bookmark inside the bookmarking-range should be accepted (but it\'s not) ' . $e->getMessage());
}

// second user bookmarks inside the bookmarking range with a negative
try
{
  $obj1->setBookmarking(-2, $user_2_id);
  $t->pass('setBookmarking() a bookmark inside the bookmarking_range is accepted');
}
catch (Exception $e)
{
  $t->fail('setBookmarking() a bookmark inside the bookmarking-range should be accepted (but it\'s not) ' . $e->getMessage());
}

// test the countBookmarking() method
$t->ok($obj1->countBookmarkings()==2, 'countBookmarkings() counts two bookmarks');

// test the getBookmarking() method (-0.5)
$t->ok($obj1->getBookmarking()==-0.5, 'getBookmarking() the average of the two bookmarks for object one is -0.5');

// test wether objects have been bookmarked at all
$t->ok($obj1->hasBeenBokmarked() == true, 'hasBeenBokmarked() obj1 has been bookmarked');
$t->ok($obj2->hasBeenBokmarked() == false, 'hasBeenBokmarked() obj2 has NOT been bookmarked');

// test wether objects have been bookmarked by a user
$t->ok($obj1->hasBeenBokmarkedByUser($user_1_id) == true, 'hasBeenBokmarkedByUser() obj1 has been bookmarked by user1');
$t->ok($obj1->hasBeenBokmarkedByUser($user_3_id) == false, 'hasBeenBokmarkedByUser() obj1 has NOT been bookmarked by user3');

// test the bookmarkingDetails() function
$bookmarking_details = $obj1->getBookmarkingDetails();
$t->ok($bookmarking_details[1] == 1 && $bookmarking_details[-2] == 1, 'getBookmarkingDetails() simple bookmarking details for the previous bookmarking are correctly extracted');
$t->ok(array_key_exists(2, $bookmarking_details) == false, 'getBookmarkingDetails() simple bookmarking details do not contain keys for unexpressed opinions');

// test the bookmarkingDetails(true) method, that extracts details for all possible keys
$full_bookmarking_details = $obj1->getBookmarkingDetails(true);
$t->ok($full_bookmarking_details[0] == 0 && $bookmarking_details[1] == 1, 'getBookmarkingDetails() full bookmarking details for the previous bookmarking are correctly extracted');

// test the getUserBookmarking() method
$t->ok($obj1->getUserBookmarking($user_1_id) == 1, "getUserBookmarking() first user bookmarked 1");
$t->ok($obj1->getUserBookmarking($user_2_id) == -2, "getUserBookmarking() second user bookmarked -2");
// second user bookmarks inside the bookmarking range with a negative
try
{
  $null_user = $obj1->getUserBookmarking(null);
  $t->fail('getUserBookmarking() when a user is not passed (null), an exception should be raised');
}
catch (Exception $e)
{
  $t->pass('getUserBookmarking() when a user is not passed, an exception is raised');
}

// test the getReferenceKey() method
sfConfig::set(
    sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_reference_field', 
            get_class($obj1)), '');
$t->is($obj1->getReferenceKey(), $obj1->getPrimaryKey(), 'getReferenceKey() get the primary key as default');


// thest the clearUserBookmarking() method
$res = $obj1->clearUserBookmarking($user_1_id);
$t->ok($obj1->hasBeenBokmarkedByUser($user_1_id) == false, 'clearUserBookmarking() remove bookmarkings of an user from an object');

// thest the clearBookmarkings() method
$res = $obj1->clearBookmarkings();
$t->ok($obj1->hasBeenBokmarked() == false, 'clearBookmarkings() remove all bookmarkings from an object');


// anonymous bookmark allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsBookmarkableBehavior_%s_anonymous_bookmarking', 
            get_class($obj1)), true);
try
{
  $obj1->setBookmarking(1);
  $t->pass('setBookmarking() an anonymous bookmark is set, when allowed');
}
catch (Exception $e)
{
  $t->fail('setBookmarking() an anonymous bookmark could not be set, even if allowed');
}

// anonymous bookmark not allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsBookmarkableBehavior_%s_anonymous_bookmarking', 
            get_class($obj1)), false);
try
{
  $obj1->setBookmarking(1);
  $t->fail('setBookmarking() an anonymous bookmark is set, even if it should not');
}
catch (Exception $e)
{
  $t->pass('setBookmarking() an anonymous bookmark is NOT set, when not allowed');
}


// first user tries to express the neutral opinion, when allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsBookmarkableBehavior_%s_neutral_position', 
            get_class($obj1)), true);
try
{
  $obj1->setBookmarking(0, $user_1_id);
  $t->pass('setBookmarking() a neutral opinion was accepted, when allowed');
}
catch (Exception $e)
{
  $t->fail('setBookmarking() a neutral opinion could not be accepted, even if allowed');
}


// first user tries to express the neutral opinion, when not allowed
sfConfig::set(
    sprintf('propel_behavior_deppPropelActAsBookmarkableBehavior_%s_neutral_position', 
            get_class($obj1)), false);
try
{
  $obj1->setBookmarking(0, $user_1_id);
  $t->fail('setBookmarking() a neutral opinion was accepted, even when not allowed');
}
catch (Exception $e)
{
  $t->pass('setBookmarking() a neutral opinion is NOT accepted, when not allowed');
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