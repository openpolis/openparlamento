<?php
for ($i=0;$i<10;$i++) echo "\n";
// Define your test Propel class with behavior applied here
define('TEST_CLASS', 'sfTestObject');
// Define a setter method for this article, other than primary key
define('TEST_METHOD', 'setTitle');

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
$t = new lime_test(46, new lime_output_color());

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

try
{
  $class = TEST_CLASS;
  $method = TEST_METHOD;
  $obj = new $class;
  if (!method_exists($obj, TEST_METHOD))
  {
    // Don't run tests at all
    return;
  }
  $obj->$method('A test object');
  $obj->save();
  $obj2 = new $class;
  $obj2->$method('Another test object');
  $obj2->save();
}
catch (Exception $e)
{
  $t->fail($e->getMessage());
}

$obj_pk = $obj->getPrimaryKey();
$t->ok(!is_null($obj_pk), 'getPrimaryKey() Test Object saved');
$obj2_pk = $obj2->getPrimaryKey();
$t->ok(!is_null($obj2_pk), 'getPrimaryKey() Other test Object saved');

// Override any existing max_rating parameter
sfConfig::set(
    sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_max_rating', 
            get_class($obj)), 5);
$t->is($obj->getMaxRating(), 5, 'getMaxRating() retrieve correct value');
sfConfig::set(
    sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_max_rating', 
            get_class($obj)), 10);
$t->is($obj->getMaxRating(), 10, 'getMaxRating() retrieve correct value, even when changed');

$max_rating = $obj->getMaxRating();
$t->isa_ok($max_rating, 'integer', 'getMaxRating() MAX_RATING is an integer');

$t->is($obj->getTitle(), 'A test object', 'getTitle() Object has been created');
$t->is($obj->hasBeenRated(), false, 'hasBeenRated() Object has not been rated yet');

// Tests will be IP address based
$user_1_id = 1;
$user_2_id = 2;
$user_3_id = 3;

$t->ok(!$obj->hasBeenRatedByUser($user_1_id), 
       'hasBeenRatedByUser() Object has not been rated by user 1 yet');

# User 1 overrate object 1
try
{
  $obj->setRating(11, $user_1_id);
  $t->fail('setRating() It is possible to overrate an object :(');
}
catch (Exception $e)
{
  $t->pass('setRating() It is impossible to overrate an object');
}

# User 1 rate with a negative value
try
{
  $obj->setRating(-1, $user_1_id);
  $t->fail('setRating() It is possible to underrate an object :(');
}
catch (Exception $e)
{
  $t->pass('setRating() It is impossible to underrate an object');
}

# User 1 rate with a string
try
{
  $obj->setRating('rototo', $user_1_id);
  $t->fail('setRating() It is possible to misrate an object :(');
}
catch (Exception $e)
{
  $t->pass('setRating() It is impossible to misrate an object');
}

# User 1 rate object 1 correctly
$u1_rating = 10;
$t->ok($obj->setRating($u1_rating, $user_1_id), 'setRating() Object rated OK by user 1 to '.$u1_rating);
$t->ok($obj->hasBeenRated(), 'hasBeenRated() Object has been rated');
$t->is($obj->hasBeenRatedByUser($user_1_id), true, 'hasBeenRatedByUser() Object has been rated by user 1');
$t->is($obj->hasBeenRatedByUser($user_2_id), false, 'hasBeenRatedByUser() Object has not been rated by user 2 yet');

$t->is($obj->getRating(), $u1_rating, 'getRating() rating retrieval OK');
$t->is($obj->getUserRating($user_1_id), $u1_rating, 'getUserRating() user rating retrieval OK');

# User 2 rate object 1
$u2_rating = 5;
$t->ok($obj->setRating($u2_rating, $user_2_id), 'setRating() Object rated by user 2 to '.$u2_rating);
$t->ok($obj->hasBeenRated(), 'hasBeenRated() Object has been rated');
$t->ok($obj->hasBeenRatedByUser($user_2_id), 'hasBeenRatedByUser() Object has been rated by user 2');

$t->is($obj->getRating(), 7.5, 'getRating() rating retrieval OK');
$t->is($obj->getUserRating($user_2_id), $u2_rating, 'getUserRating() user rating retrieval OK');

# User 1 rates object 2
$obj2->setRating(5, $user_1_id);
$t->is($obj2->getUserRating($user_1_id), 5, 'getUserRating() user rating retrieval OK');
$t->is($obj2->getRating(), 5, 'getRating() rating ok');
$obj2->clearRatings();
$t->is($obj2->getRating(), null, 'clearRatings() clear rating ok');

# User 2 changes his rating for object 1
$u2_rating = 8;
$t->ok($obj->setRating($u2_rating, $user_2_id), 'setRating() User 2 changes his rating to '.$u2_rating);
$t->ok($obj->hasBeenRatedByUser($user_2_id), 'hasBeenRatedByUser() Object is still rated by user 2');

$t->is($obj->getRating(), 9, 'getRating() rating retrieval = 9');
$t->is($obj->getUserRating($user_2_id), $u2_rating, 'getUserRating() user rating retrieval OK');

# User 1 changes his rating
$u1_rating = 2;
$t->ok($obj->setRating($u1_rating, $user_1_id), 'setRating() User 1 changes his rating to '.$u1_rating);
$t->ok($obj->hasBeenRatedByUser($user_1_id), 'hasBeenRatedByUser() Object is still rated by user 1');

$t->is($obj->getRating(), 5, 'getRating() rating retrieval OK');
$t->is($obj->getUserRating($user_1_id), $u1_rating, 'getUserRating() user rating retrieval OK');

# User 1 cancel his rating
$t->ok($obj->clearUserRating($user_2_id), 'cleanUserRating() User 2 cleans his rating');
$t->ok(!$obj->hasBeenRatedByUser($user_2_id), 'hasBeenRatedByUser() Object has now not been rated by user 2');
$t->is($obj->getRating(), $u1_rating, 'getRating() Object rating has been updated');

$t->ok($obj->clearRatings(), 'cleanRatings() All ratings are cleared');
$t->is($obj->getRating(), NULL, 'getRating() Rating is now NULL for this object');

// Rating based on a 12 max rating
$obj->clearRatings();
$obj2->clearRatings();
sfConfig::set(
    sprintf('propel_behavior_sfPropelActAsRatableBehavior_%s_max_rating', 
            get_class($obj)), 12);

$obj->setRating(6, $user_1_id);
$obj->setRating(6, $user_2_id);
$t->is($obj->getRating(), 6, 'getRating() base12 ok');
$obj->setRating(12, $user_2_id);
$t->is($obj->getRating(), 9, 'getRating() base12 ok');
$obj->setRating(3, $user_1_id);
$t->is($obj->getRating(), 7.5, 'getRating() base12 ok');

// Testing ratings details retrieval
$obj->setRating(6, $user_1_id);
$obj->setRating(6, $user_2_id);
$obj->setRating(7, $user_3_id);
$details = $obj->getRatingDetails();
$t->is(count($details), 2, 'getRatingDetails() count ok');
$t->is_deeply($details, array(6 => 2, 7 => 1), 'getRatingDetails() results are conform');

$full_details = $obj->getRatingDetails(true);
$t->is(count($full_details), 12, 'getRatingDetails(true) count ok');
$expected = array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>2, 7=>1, 8=>0, 9=>0, 10=>0, 11=>0, 12=>0);
$t->is_deeply($full_details, $expected, 'getRatingDetails(true) results are conform');

// Testing cascade deletion
$obj_key = $obj->getPrimaryKey();
$obj->delete();
$c = new Criteria();
$c->add(sfRatingPeer::RATABLE_ID, $obj_key);
$count = sfRatingPeer::doCount($c);
$t->is($count, 0, 'doCount() No more rating records for deleted object');

// Delete remaining object
$obj2->delete();

$t->diag('Tests are now terminated');