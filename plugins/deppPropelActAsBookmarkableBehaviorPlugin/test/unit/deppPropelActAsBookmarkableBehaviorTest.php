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
$t = new lime_test(22, new lime_output_color());

$t->diag('deppPropelActAsBookmarkableBehaviorPlugin API unit test');

$t->diag('Tests beginning');

// cleanup the DB 
// remove all objects of type TEST_CLASS, and, 
// by CASCADE-emulation all the records in sf_bookmarkings
$test_recs = call_user_func(array(_create_object()->getPeer(), 'doSelect'), new Criteria());
foreach ($test_recs as $test_rec) {
  $test_rec->delete();
}

// an object is created and a test on the countBookmarkings and getBookmarking values is performed
$obj1 = _create_object();
$t->ok($obj1->countPositiveBookmarkings() == 0, 'countPositiveBookmarkings() - a new object has no positive bookmarkings.');
$t->ok($obj1->countNegativeBookmarkings() == 0, 'countNegativeBookmarkings() - a new object has no negative bookmarkings.');
$obj1->save();


// define three users
$user_1_id = 1;
$user_2_id = 4;
$user_3_id = 6;

$t->diag("Object1 is bookmarked by user1 and user2, positively and negatively resp.");

// first user bookmarks the first object positively
try
{
  $obj1->setPositiveBookmarking($user_1_id);
  $t->pass('setPositiveBookmarking() obj1 was positively bookmarked by user1');
}
catch (Exception $e)
{
  $t->fail('setPositiveBookmarking() obj1 could not be positively bookmarked by user1 ' . $e->getMessage());
}
$t->ok($obj1->countPositiveBookmarkings() == 1, 'countPositiveBookmarkings() - obj1 has one positive bookmarking.');

// second user bookmarks the first object negatively
try
{
  $obj1->setNegativeBookmarking($user_2_id);
  $t->pass('setNegativeBookmarking() obj2 was negatively bookmarked by user2');
}
catch (Exception $e)
{
  $t->fail('setNegativeBookmarking() obj1 could not be negatively bookmarked by user2 ' . $e->getMessage());
}
$t->ok($obj1->countNegativeBookmarkings() == 1, 'countNegativeBookmarkings() - obj1 has one negative bookmarking.');


$t->diag("User3 bookmarks negatively object1, then remove the bookmarking");
$obj1->setNegativeBookmarking($user_3_id);
$t->ok($obj1->countNegativeBookmarkings() == 2, 'countNegativeBookmarkings() - obj1 has two negative bookmarkings.');
// second user bookmarks the first object negatively
try
{
  $obj1->removeNegativeBookmarking($user_3_id);
  $t->pass('removeNegativeBookmarking() - a negative bookmark on obj1 was removed by user3');
}
catch (Exception $e)
{
  $t->fail('removeNegativeBookmarking() - a negative bookmark on obj1 could not be removed by user3');
}
$t->ok($obj1->countNegativeBookmarkings() == 1, 'countNegativeBookmarkings() - obj1 has one negative bookmarking.');

$t->ok($obj1->hasBeenPositivelyBookmarked($user_1_id) == true, 'hasBeenPositivelyBookmarked() - obj1 was positively bookmarked by user 1');
$t->ok($obj1->hasBeenNegativelyBookmarked($user_1_id) == false, 'hasBeenNegativelyBookmarked() - obj1 was NOT negatively bookmarked by user 1');
$t->ok($obj1->hasBeenPositivelyBookmarked($user_2_id) == false, 'hasBeenPositivelyBookmarked() - obj1 was NOT positively bookmarked by user 1');
$t->ok($obj1->hasBeenNegativelyBookmarked($user_2_id) == true, 'hasBeenNegativelyBookmarked() - obj1 was negatively bookmarked by user 1');
$t->ok($obj1->hasBeenNegativelyBookmarked($user_3_id) == false, 'hasBeenNegativelyBookmarked() - obj1 was NOT negatively bookmarked by user 1');


$t->diag('List of bookmarked objects');
$bookmarked_ids = sfBookmarkingPeer::getAllPositivelyBookmarkedIds($user_1_id);
$t->ok($bookmarked_ids[TEST_CLASS][0] == $obj1->getId(), 'sfBookmarkingPeer::getAllPositivelyBookmarkedIds() - is working');
$bookmarked_ids = sfBookmarkingPeer::getAllPositivelyBookmarkedIds($user_2_id);
$t->ok($bookmarked_ids == array(), 'sfBookmarkingPeer::getAllPositivelyBookmarkedIds() - empty case scenario');

$bookmarked_ids = sfBookmarkingPeer::getAllNegativelyBookmarkedIds($user_2_id);
$t->ok($bookmarked_ids[TEST_CLASS][0] == $obj1->getId(), 'sfBookmarkingPeer::getAllNegativelyBookmarkedIds() - is working');
$bookmarked_ids = sfBookmarkingPeer::getAllNegativelyBookmarkedIds($user_1_id);
$t->ok($bookmarked_ids == array(), 'sfBookmarkingPeer::getAllNegativelyBookmarkedIds() - empty case scenario');

$bookmarked_objs = sfBookmarkingPeer::getAllPositivelyBookmarked($user_1_id);
$t->ok($bookmarked_objs[0] == $obj1, 'sfBookmarkingPeer::getAllPositivelyBookmarked() - is working');

$bookmarked_objs = sfBookmarkingPeer::getAllNegativelyBookmarked($user_2_id);
$t->ok($bookmarked_objs[0] == $obj1, 'sfBookmarkingPeer::getAllNegativelyBookmarked() - is working');

$bookmarked_objs = sfBookmarkingPeer::getAllPositivelyBookmarked($user_2_id);
$t->ok($bookmarked_objs == array(), 'sfBookmarkingPeer::getAllPositivelyBookmarked() - empty case');

$t->diag('List of some toolkit methods');
$t->ok(deppPropelActAsBookmarkableToolkit::isBookmarkable(TEST_CLASS) == true,
       'deppPropelActAsBookmarkableToolkit::isBookmarkable() - is working');

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