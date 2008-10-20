<?php
// to have the test not destroy existing objects, create an sf_test_object in the DB and model
// you can obviously choose the name you like, but you have to change it here
define('TEST_CLASS', 'sfTestObject');

// a method to extract the cached number of comments is used
// remember to add setSfCommentCount as cache_count_method in the sfTestObject definition
define('TEST_CACHE_COUNT_GETTER', 'getSfCommentCount');

// initializes testing framework (change app name)
$app = 'fe';
include(dirname(__FILE__).'/../../../../test/bootstrap/functional.php');
include($sf_symfony_lib_dir.'/vendor/lime/lime.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();
$con = Propel::getConnection();

// clean the database (cleaning testObject, cleans all the referenced comments, 
//  due to the preSave hook)
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

// start tests
$t = new lime_test(17, new lime_output_color());

// these tests check for the comments adding consistency
$t->diag('comments adding consistency');

$object1 = _create_object();
$t->ok($object1->getComments() == array(), 'a new object has no comment.');

$object1->save();
$str = 'One first, simple, stringy comment.';
$object1->addComment($str);
$object_comments = $object1->getComments();
$t->ok((count($object_comments) == 1 && ($object_comments[0]['Text'] == $str)), 'a saved object can get commented.');

$object1->addComment('One second comment.');
$t->ok($object1->getNbComments() == 2, 'one object can have several comments.');

$object2 = _create_object();
$object2->save();

$object2->addComment('One first comment on object2.');
$object1_comments = $object1->getComments();
$object2_comments = $object2->getComments();
$t->ok((count($object1_comments) == 2) && (count($object2_comments) == 1), 'one comment is only attached to one Propel object.');
$t->ok(count($object1_comments) == $object1->getNbComments(), 'getNbComment() allows to retrieve one object\'s comments number.');

$object3 = _create_object();
$object3->save();
$comment1 = array('text'         => 'One first comment', 
                  'author_name'  => 'Gérard', 
                  'author_email' => 'gerard@lambert.com');
$object3->addComment($comment1);
$t->ok($object3->getNbComments() == 1, 'comments can also be attached using arrays.');
$comment2 = array('text'         => 'My Back-office comment', 
                  'author_name'  => 'Gérard', 
                  'author_email' => 'gerard@lambert.com',
                  'namespace'    => 'backend');
$object3->addComment($comment2);
$t->ok(($object3->getNbComments() == 2) && ($object3->getNbComments(array('namespace' => 'backend')) == 1), 'comments are separated into namespaces, and can be retrieved separately.');


// these tests check for other methods
$t->diag('comments manipulation methods');
sfCommentPeer::doDeleteAll();

$object1 = _create_object();
$object1->save();
$object1->addComment('One first comment.');
$object1->addComment('One second comment.');
$object_comments = $object1->getComments();
$nb_object_comments = $object1->getNbComments();
$t->ok(($nb_object_comments == count($object_comments)) && ($nb_object_comments == 2), 'getNbComments() returns the number of comments attached to the object when it has still not been saved.');

$object1->addComment('One third comment.');
$object1->save();
$object_comments = $object1->getComments();
$nb_object_comments = $object1->getNbComments();
$t->ok(($nb_object_comments == count($object_comments)) && ($nb_object_comments == 3), 'getNbComments() returns the number of comments attached to the object, when it has been saved also.');

$object1->clearComments();
$t->ok($object1->getNbComments() === 0, 'comments on an object can be cleared using clearComments().');


// these tests check for comments retrieval methods
$t->diag('comments retrieval methods');
sfCommentPeer::doDeleteAll();

$object1 = _create_object();
$object1->save();
$object1->addComment('One first comment.');
$object1->addComment('One second comment.');
$asc_comments = $object1->getComments(array('order' => 'asc'));
$desc_comments = $object1->getComments(array('order' => 'desc'));
$t->ok(   ($asc_comments[0]['Text'] == 'One first comment.') 
       && ($asc_comments[1]['Text'] == 'One second comment.') 
       && ($desc_comments[1]['Text'] == 'One first comment.') 
       && ($desc_comments[0]['Text'] == 'One second comment.'), 'comments can be retrieved in a specific order.');



// test count cache, removal publish/unpublish)
// default values are used (i.e. the number of public comments is cached)
$t->diag('count cache');
$object2 = _create_object();
$object2->save();
$object2->addComment('My first');
$object2->addComment('My second');
$t->ok( call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == 2 &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == $object2->getNbComments(), 'count cache is working properly while adding comments.');
$comments = $object2->getComments();

$t->diag('publish/unpublish');
$object2->unpublishComment($comments[0]['Id']);
$t->ok( call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == 1 &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) != $object2->getNbComments() &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == $object2->getNbPublicComments(), 'unpublishing works fine (and cache is ok)');

$object2->publishComment($comments[0]['Id']);
$t->ok( call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == 2 &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == $object2->getNbComments() &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == $object2->getNbPublicComments(), 'publishing works fine (and cache is ok)');

$t->diag('removal');
$object2->removeComment($comments[0]['Id']);
$t->ok( call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == 1 &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == $object2->getNbComments() &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == $object2->getNbPublicComments(), 'removing works fine (and cache is ok)');

$object2->clearComments();
$t->ok( call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == 0 &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == $object2->getNbComments() &&
        call_user_func(array($object2, TEST_CACHE_COUNT_GETTER )) == $object2->getNbPublicComments(), 'clearing all comments fine (and cache is ok)');



// these tests check for comments inserted by authenticated users
$t->diag('comments by authenticated users');

// autenticazione (user_id = 8, è un utenza con mail e website)
// bisogna settare 
//  enabled: true
//  name_method, email_method, website_method

$user = OppUserPeer::retrieveByPK(8);
sfContext::getInstance()->getUser()->signIn($user);

$object1 = _create_object();
$object1->setName('oggetto per commento autenticato');
$object1->save();
$object1->addComment('My first comment.');
$comments = $object1->getComments();
$t->ok( $comments[0]['AuthorId'] != null &&
        $comments[0]['AuthorName'] != null &&
        $comments[0]['AuthorWebsite'] != null, 
        'comments by authenticated users have an author_id field');

// logout
sfContext::getInstance()->getUser()->signOut();











// test object creation
function _create_object()
{
  $classname = TEST_CLASS;

  if (!class_exists($classname))
  {
    throw new Exception(sprintf('Unknow class "%s"', $classname));
  }

  $obj = new $classname;
  // set a field (name) to set the status of the object to isModified and have the doSave() function work
  $obj->setName('Nome di prova');
  return $obj;
}