<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
  * @package sfLucenePlugin
  * @subpackage Test
  * @author Carl Vondrick
  */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require dirname(__FILE__) . '/../../bin/FakeLucene.php';

class Foo { }
class Bar extends BaseObject { }

$t = new lime_test(10, new lime_output_color());

$lucene = FakeLucene::getInstance('lucene', 'en');
$indexer = $lucene->getIndexer();

$model = new Forum;

$t->diag('testing factory');
$t->isa_ok($indexer, 'sfLuceneIndexerFactory', '->getIndexer() returns the factory');

$indexer = $indexer->getModel($model);
$t->isa_ok($indexer, 'sfLucenePropelIndexer', '->getIndexer()->getModel() returns the propel indexer');

$t->diag('testing normal conditions');

$numDocs = $lucene->numDocs();

$model->setTitle('Test');
$model->setDescription('this is cool');
$model->setId(99);

try {
  $indexer->insert();
  $t->pass('->insert() inserts a valid model without exception');
} catch (Exception $e) {
  $t->fail('->insert() inserts a valid model without exception');
}

$lucene->commit();

$t->is($lucene->numDocs(), $numDocs + 1, '->numDocs() returns a document count increased by one');

try {
  $indexer->delete();
  $t->pass('->delete() deletes a valid model without exception');
} catch (Exception $e) {
  $t->fail('->delete() deletes a valid model without exception');
}

$lucene->commit();

$t->is($lucene->numDocs(), $numDocs, '->numDocs() returns a document count that is back to original value');

$t->diag('testing bad inputs');

try {
  $lucene->getIndexer()->getModel(new Foo())->insert();
  $t->fail('->insert() rejects an invalid model');
} catch (Exception $e) {
  $t->pass('->insert() rejects an invalid model');
}

try {
  $lucene->getIndexer()->getModel(new Foo())->delete();
  $t->fail('->delete() rejects an invalid model');
} catch (Exception $e) {
  $t->pass('->delete() rejects an invalid model');
}

try {
  $lucene->getIndexer()->getModel(new Bar())->insert();
  $t->fail('->insert() rejects unregistered model');
} catch (Exception $e) {
  $t->pass('->insert() rejects unregistered model');
}

try {
  $lucene->getIndexer()->getModel(new Foo())->delete();
  $t->fail('->delete() rejects unregistered model');
} catch (Exception $e) {
  $t->pass('->delete() rejects unregistered model');
}