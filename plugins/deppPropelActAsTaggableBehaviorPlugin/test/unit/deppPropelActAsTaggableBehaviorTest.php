<?php
// test variables definition
define('TEST_CLASS', 'Post');
define('TEST_CLASS_2', 'Link');

// initializes testing framework
$sf_root_dir = realpath(dirname(__FILE__).'/../../../../');
$apps_dir = glob($sf_root_dir.'/apps/*', GLOB_ONLYDIR);
$app = substr($apps_dir[0],
              strrpos($apps_dir[0], DIRECTORY_SEPARATOR) + 1,
              strlen($apps_dir[0]));
if (!$app)
{
  throw new Exception('No app has been detected in this project');
}

require_once($sf_root_dir.'/test/bootstrap/functional.php');
require_once($sf_symfony_lib_dir.'/vendor/lime/lime.php');

if (!defined('TEST_CLASS') || !class_exists(TEST_CLASS)
    || !defined('TEST_CLASS_2') || !class_exists(TEST_CLASS_2))
{
  // Don't run tests
  return;
}

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();
$con = Propel::getConnection();

// clean the database
TagPeer::doDeleteAll();
TaggingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

// start tests
$t = new lime_test(66, new lime_output_color());


// these tests check for the tags attachement consistency
$t->diag('tagging consistency');

$object = _create_object();
$t->ok($object->getTags() == array(), 'a new object has no tag.');

$object->addTag('toto');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 1) && ($object_tags['toto'] == 'toto'), 'a non-saved object can get tagged.');

$object->addTag('toto');
$object_tags = $object->getTags();
$t->ok(count($object_tags) == 1, 'a tag is only applied once to non-saved objects.');
$object->save();

$object->addTag('toto');
$object_tags = $object->getTags();
$t->ok(count($object_tags) == 1, 'a tag is also only applied once to saved objects.');
$object->save();

$object->addTag('tutu');
$object_tags = $object->getTags();
$t->ok($object->hasTag('tutu'), 'a saved object can get tagged.');
$object->save();

// get the key of this object
$id1 = $object->getPrimaryKey();

$object->removeTag('tutu');
$t->ok(!$object->hasTag('tutu'), 'a previously saved tag can be removed.');

$object->addTag('tata');
$object->removeTag('tata');
$t->ok(!$object->hasTag('tata'), 'a non-saved tag can also be removed.');

$object->addTag('tu\'tu');
$t->ok($object->hasTag('tu\'tu'), 'a tag can contain a quote.');

$object2 = _create_object();
$object_tags = $object2->getTags();
$t->ok(count($object_tags) == 0, 'a new object has no tag, even if other tagged objects exist.');
$object2->save();

$object2->addTag('titi');
$t->ok($object2->hasTag('titi'), 'a new object can get tagged, even if other tagged objects exist.');
$t->ok(!$object->hasTag('titi'), 'tags applied to new objects do not affect old ones.');
$object2->save();
$id2 = $object2->getPrimaryKey();

$object2_copy = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id2);
$object2_copy->addTag('clever');
$t->ok($object2_copy->hasTag('clever') && !$object2->hasTag('clever'), 'tags are applied to the object instances independently.');

$object = _create_object();
$object->addTag('tutu');
$object->addTag('titi');
$object->save();
$object->addTag('tata');
$object->removeAllTags();
$t->ok(!$object->hasTag(), 'tags can all be removed at once.');

$object = _create_object();
$object->addTag('toto,international,tata');
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$object->removeTag('tata');
$object->addTag('tata');
$object->save();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$object_tags = $object->getTags();
$t->ok(count($object_tags) == 3, 'when removing one previously saved tag, then restoring it, and then saving it again, this tag is not duplicated.');

$object = _create_object();
$object->addTag('toto,tutu,tata');
$object->save();
$object->removeAllTags();
$object->addTag('toto,tutu,tata');
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$object_tags = $object->getTags();
$t->ok(count($object_tags) == 3, 'when removing all previously saved tags, then restoring it, and then saving it again, tags are not duplicated.');

$object = _create_object();
$object->addTag('toto,tutu,tata');
$object->save();
$previous_count = count($object->getTags());
$object->removeAllTags();
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$t->ok(($previous_count == 3) && !$object->hasTag(), 'previously in-database tags can be deleted.');

$object = _create_object();
$object->addTag('toto, tutu, test');
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);

$object2 = _create_object();
$object2->addTag('clever age, symfony, test');
$object2->save();
$object2->removeTag('test');
$object2->save();

$object_tags = $object->getTags();
$object2_tags = $object2->getTags();
$t->ok((count($object2_tags) == 2) && (count($object_tags) == 3), 'removing one tag as no effect on the other tags of the object, neither on the other objects.');

$object2_tags = $object2->getTags(array('serialized' => true));
$t->ok($object2_tags == 'clever age, symfony', 'tags can be retrieved in a serialized form.');

$object->removeAllTags();
$object->setTags('');
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$t->ok(count($object->getTags()) == 0, 'when the tags are set twice, or all removed twice, before the object is saved, then all the prvious tags are still removed.');

unset($object, $object2, $object2_copy);


// these tests check the various methods for applying tags to an object
$t->diag('various methods for applying tags');
$object = _create_object();
$object->addTag('toto');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 1) && ($object_tags['toto'] == 'toto'), 'one tag can be added alone.');

$object->addTag('titi,tutu');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 3) && $object->hasTag('tutu') && $object->hasTag('titi'), 'tags can be added with a comma-separated string.');
$t->ok($object->hasTag('titi, tutu'), 'comma-separated strings are divided into several tags.');

$object = _create_object();
$object->addTag('titi
tutu');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 2) && $object->hasTag('titi') && $object->hasTag('tutu'), 'tags can be added using line breaks as separators.');
$t->ok($object->hasTag('titi
tutu'), 'line-breaks-separated strings are divided into several tags.');

$object = _create_object();
$object->addTag('titi

tutu');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 2) && $object->hasTag('titi') && $object->hasTag('tutu'), 'when adding tags using line breaks as separators, remove blank lines.');

$object = _create_object();
$object->addTag(array('titi', 'tutu'));
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 2) && $object->hasTag('tutu') && $object->hasTag('titi'), 'tags can be added with an array.');

$object->setTags('wallace, gromit');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 2) && $object->hasTag('wallace') && $object->hasTag('gromit'), 'tags can be set directly using setTags().');

unset($object);


// these tests check for the tagging removal on object deletion

// clean the database
TagPeer::doDeleteAll();
TaggingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

$t->diag('taggings removal on objects deletion');
$object1 = _create_object();
$object1->addTag('tag2,tag3,tag1,tag4,tag5,tag6');
$object1->save();

$object2 = _create_object();
$object2->addTag('tag4,tag7,tag8');
$object2->save();

$object2->delete();

$tags = TagPeer::getAllWithCount();
$t->ok(isset($tags['tag4']) && !isset($tags['tag7']), 'the taggings associated to one object are deleted when this object is deleted.');


// these tests check for TagPeer methods (tag clouds generation)

// clean the database
TagPeer::doDeleteAll();
TaggingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

$t->diag('tag clouds');
$object1 = _create_object();
$object1->addTag('tag2,tag3,tag1,tag4,tag5,tag6');
$object1->save();

$object2 = _create_object();
$object2->addTag('tag1,tag3,tag4,tag7');
$object2->save();

$object3 = _create_object();
$object3->addTag('tag2,tag3,tag7,tag8');
$object3->save();

$object4 = _create_object();
$object4->addTag('tag3');
$object4->save();

$object5 = _create_object();
$object5->addTag('tag1,tag3,tag7');
$object5->save();

// getAll() test
$tags = TagPeer::getAll();
$result = array();

foreach ($tags as $tag)
{
  $result[] = $tag->getName();
}

$t->ok($result == array('tag2', 'tag3', 'tag1', 'tag4', 'tag5', 'tag6', 'tag7', 'tag8'), 'all tags can be retrieved with getAll().');

// getAllWithCount() test
$tags = TagPeer::getAllWithCount();
$t->ok($tags == array('tag1' => 3, 'tag2' => 2, 'tag3' => 5, 'tag4' => 2, 'tag5' => 1, 'tag6' => 1, 'tag7' => 3, 'tag8' => 1), 'all tags can be retrieved with getAll().');

// getPopulars() test
$c = new Criteria();
$c->setLimit(3);
$tags = TagPeer::getPopulars($c);
$t->ok(array_keys($tags) == array('tag1', 'tag3', 'tag7'), 'most popular tags can be retrieved with getPopulars().');
$t->ok($tags['tag3'] >= $tags['tag1'], 'getPopulars() preserves tag importance.');

// getRelatedTags() test
$tags = TagPeer::getRelatedTags('tag8');
$t->ok(array_keys($tags) == array('tag2', 'tag3', 'tag7'), 'related tags can be retrieved with getRelatedTags().');

$c = new Criteria();
$tags = TagPeer::getRelatedTags('tag2', array('limit' => 1));
$t->ok(array_keys($tags) == array('tag3'), 'when a limit is set, only most popular related tags are returned by getRelatedTags().');

// getRelatedTags() test
$tags = TagPeer::getRelatedTags('tag7');
$t->ok(array_keys($tags) == array('tag1', 'tag2', 'tag3', 'tag4', 'tag8'), 'getRelatedTags() aggregates tags from different objects.');

// getRelatedTags() test
$tags = TagPeer::getRelatedTags(array('tag2', 'tag7'));
$t->ok(array_keys($tags) == array('tag3', 'tag8'), 'getRelatedTags() can retrieve tags related to an array of tags.');

// getRelatedTags() test
$tags = TagPeer::getRelatedTags('tag2,tag7');
$t->ok(array_keys($tags) == array('tag3', 'tag8'), 'getRelatedTags() also accepts a coma-separated string.');

// getTaggedWith() tests
$object_2_1 = _create_object_2();
$object_2_1->addTag('tag1,tag3,tag7');
$object_2_1->save();

$object_2_2 = _create_object_2();
$object_2_2->addTag('tag2,tag7');
$object_2_2->save();

$tagged_with_tag4 = TagPeer::getTaggedWith('tag4');
$t->ok(count($tagged_with_tag4) == 2, 'getTaggedWith() returns objects tagged with one specific tag.');

$tagged_with_tag7 = TagPeer::getTaggedWith('tag7');
$t->ok(count($tagged_with_tag7) == 5, 'getTaggedWith() can return several object types.');

$tagged_with_tag17 = TagPeer::getTaggedWith(array('tag1', 'tag7'));
$t->ok(count($tagged_with_tag17) == 3, 'getTaggedWith() returns objects tagged with several specific tags.');

$tagged_with_tag127 = TagPeer::getTaggedWith('tag1, tag2, tag7',
                                             array('nb_common_tags' => 2));
$t->ok(count($tagged_with_tag127) == 6, 'the "nb_common_tags" option of getTaggedWith() returns objects tagged with a certain number of tags within a set of specific tags.');

// these tests check the isTaggable() method
$t->diag('detecting if a model is taggable or not');

$t->ok(deppPropelActAsTaggableToolkit::isTaggable(TEST_CLASS) === true, 'it is possible to tell if a model is taggable from its name.');

$object = _create_object();
$t->ok(deppPropelActAsTaggableToolkit::isTaggable($object) === true, 'it is possible to tell if a model is taggable from one of its instances.');
$t->ok(deppPropelActAsTaggableToolkit::isTaggable('Tristan\'s cat') === false, 'Tristan\'s cat is not taggable, and that is fine.');


TagPeer::doDeleteAll();
TaggingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));


// these tests check for the application of triple tags

$t->diag('applying triple tagging');

$t->ok(deppPropelActAsTaggableToolkit::extractTriple('ns:key=value') === array('ns:key=value', 'ns', 'key', 'value'), 'triple extracted successfully.');
$t->ok(deppPropelActAsTaggableToolkit::extractTriple('ns:key') === array('ns:key', null, null, null), 'ns:key is not a triple.');
$t->ok(deppPropelActAsTaggableToolkit::extractTriple('ns') === array('ns', null, null, null), 'ns is not a triple.');

$object = _create_object();
$object->addTag('tutu');
$object->save();

$object = _create_object();
$object->addTag('ns:key=value');
$object->addTag('ns:key=tutu');
$object->addTag('ns:key=titi');
$object->addTag('ns:key=toto');
$object->save();

$object_tags = $object->getTags();
$t->ok($object->hasTag('ns:key=value'), 'object has triple tag');

$tag = TagPeer::retrieveOrCreateByTagname('ns:key=value');
$t->ok($tag->getIsTriple(), 'a triple tag created from a string is identified as a triple.');

$tag = TagPeer::retrieveOrCreateByTagname('tutu');
$t->ok(!$tag->getIsTriple(), 'a non tripled tag created from a string is not identified as a triple.');


// these tests check the retrieval of the tags of one object, based on
// triple-tags constraints

$t->diag('retrieving triple tags, and extracting only parts of it');

$object = _create_object();
$object->addTag('geo:lat=50.7');
$object->addTag('geo:long=6.1');
$object->addTag('de:city=Aachen');
$object->addTag('fr:city=Aix la Chapelle');
$object->addTag('en:city=Aix Chapel');
$object->save();

// get all the tags
$tags = $object->getTags();
$t->ok(count($tags) == 5, 'The addTags() method permits to create triple tags, that can be retrieved using getTags().');

$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$tags = $object->getTags();
$t->ok(count($tags) == 5, 'The addTags() method permits to create triple tags, that can be retrieved using getTags(), even when saved.');

// get all the informations in the "geo" namespace
$tags = $object->getTags(array('is_triple' => true,
                               'namespace' => 'geo',
                               'return'    => 'value'));
$t->ok(count($tags) == 2, 'The getTags() method permits to select triple tags in one specific namespace.');

// get all the values of the triple tags for which the key is "city", whatever
// the namespace
$tags = $object->getTags(array('is_triple' => true,
                               'key'       => 'city',
                               'return'    => 'value'));
$t->ok(count($tags) == 3, 'The getTags() method permits to select triple tags for one specific key.');

$object2 = _create_object();
$object2->addTag('geo:lat=48.8');
$object2->addTag('geo:long=2.4');
$object2->addTag('de:city=Paris');
$object2->addTag('fr:city=Paris');
$object2->addTag('en:city=Paris');
$object2->save();

// get all the values of the triple tags for which the key is "city", whatever
// the namespace
$tags = $object2->getTags(array('is_triple' => true,
                                'key'       => 'city',
                                'return'    => 'value'));
$t->ok(count($tags) == 1, 'When selecting only the values of triple tags of one object, there is no duplicate.');

$ns = $object2->getTags(array('is_triple' => true,
                              'return'    => 'namespace'));
$t->ok(count($ns) == 4, 'The method getTags() permit to select only the names of the namespaces of the tags attached to one object.');


// these tests check for TagPeer triple tags specific methods (tag clouds generation)
sfConfig::set('app_deppPropelActAsTaggableBehaviorPlugin_triple_distinct', false);
$t->diag('querying triple tagging');

$tags_triple = TagPeer::getAll(null, array('triple' => true));
$result = array();

foreach ($tags_triple as $tag)
{
  $result[] = $tag->getName();
}

$t->ok(in_array('ns:key=value', $result), 'triple tags are returned when searching for triples only.');
$t->ok(!in_array('tutu', $result), 'ordinary tags are not returned when searching for triples only.');

$tags_triple = TagPeer::getAll(null, array('triple' => false));
$result = array();

foreach ($tags_triple as $tag)
{
  $result[] = $tag->getName();
}

$t->ok(in_array('tutu', $result), 'normal tags are returned when searching for ordinary ones only.');
$t->ok(!in_array('ns:key=value', $result), 'triple tags are not returned when searching for normal ones.');


// these tests the search of specific triple tags parts

$t->diag('searching for specific parts of triple');
$tags_triple = TagPeer::getAll(null, array('triple' => true, 'namespace' => 'ns'));
$result = array();

foreach ($tags_triple as $tag)
{
  $result[] = $tag->getName();
}

$t->ok($result === array('ns:key=value', 'ns:key=tutu', 'ns:key=titi', 'ns:key=toto'), 'it is possible to search for triple tags by namespace.');

$tags_triple = TagPeer::getAll(null, array('triple' => true, 'key' => 'key'));
$result = array();

foreach ($tags_triple AS $tag)
{
  $result[] = $tag->getName();
}

$t->ok($result === array('ns:key=value', 'ns:key=tutu', 'ns:key=titi', 'ns:key=toto'), 'it is possible to search for triple tags by key.');

$tags_triple = TagPeer::getAll(null, array('triple' => true, 'value' => 'tutu'));
$result = array();

foreach ($tags_triple as $tag)
{
  $result[] = $tag->getName();
}

$t->ok($result === array('ns:key=tutu'), 'it is possible to search for triple tags by value.');

$objects_triple = TagPeer::getTaggedWith(array(), array('namespace' => 'ns', 'model' => 'Post'));
$t->ok(count($objects_triple) == 1, 'it is possible to retrieve objects tagged with certain triple tags.');


// these tests check for the behavior of the triple tags when the plugin is set
// up so that namespace:key is a unique key

// clean the database
TagPeer::doDeleteAll();
TaggingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

sfConfig::set('app_deppPropelActAsTaggableBehaviorPlugin_triple_distinct', true);
$t->diag('querying triple tagging');

$object = _create_object();
$object->addTag('tutu');
$object->save();

$object = _create_object();
$object->addTag('ns:key=value');
$object->addTag('ns:key=tutu');
$object->addTag('ns:key=titi');
$object->addTag('ns:second_key=toto');
$object->save();

$tags_triple = TagPeer::getAll(null, array('triple' => true, 'namespace' => 'ns'));
$t->ok(count($tags_triple) == 2, 'it is possible to set up the plugin so that namespace:key is a unique key.');

$object2 = _create_object();
$object2->addTag('ns:key=value');
$object2->addTag('ns:second_key=toto');
$object2->save();

$tags_triple = TagPeer::getAll(null, array('triple' => true, 'namespace' => 'ns'));
$t->ok(count($tags_triple) == 3, 'it is possible to apply triple tags to various objects when the plugin is set up so that namespace:key is a unique key.');



// test object creation
function _create_object()
{
  $classname = TEST_CLASS;

  if (!class_exists($classname))
  {
    throw new Exception(sprintf('Unknow class "%s"', $classname));
  }

  return new $classname();
}

// second type of test object creation
function _create_object_2()
{
  $classname = TEST_CLASS_2;

  if (!class_exists($classname))
  {
    throw new Exception(sprintf('Unknow class "%s"', $classname));
  }

  return new $classname();
}
