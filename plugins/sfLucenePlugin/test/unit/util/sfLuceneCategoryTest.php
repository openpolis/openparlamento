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
require dirname(__FILE__) . '/../../bin/FakeCategory.php';

$t = new lime_test(14, new lime_output_color());

FakeCategory::_setup();

$t->diag('testing constructor');

$lucene = FakeLucene::getInstance('lucene', 'en');
$lucene2 = FakeLucene::getInstance('lucene', 'fr');

try {
  $php = FakeCategory::newInstance('PHP', $lucene);
  $hpp = FakeCategory::newInstance('HPP', $lucene2);

  $t->pass('::newInstance() accepts valid words and valid cultures');
} catch (Exception $e) {
  $t->fail('::newInstance() accepts valid word and valid culture');
}

$t->diag('testing reference counters');

$t->is($php->countReferences(), 0, '->countReferences() is 0 by default');

$php->addReference();
$t->is($php->countReferences(), 1, '->addReferences() makes ->countReferences() update');

$hpp->addReference(100);
$t->is($hpp->countReferences(), 100, '->addReference() can add large amounts of references at once');

$php->addReference(4);
$t->is($php->countReferences(), 5, '->addReferences() makes ->countReferences() update');

$php->removeReference();
$t->is($php->countReferences(), 4, '->removeReference() makes ->countReferences() update');

$php->removeReference(2);
$t->is($php->countReferences(), 2, '->removeReference() makes ->countReferences() update');

$t->diag('testing saving');

$php->save();

if ($t->ok(file_exists(FakeCategory::_getLocation()), '->save() writes data to disk'))
{
  $categories = array();
  include(FakeCategory::_getLocation());

  if (isset($categories['lucene']['en']['PHP']))
  {
    $t->is($categories['lucene']['en']['PHP'], 2, '->save() writes accurate information');
  }
  else
  {
    $t->fail('->save() writes accurate information');
  }
}

$t->diag('testing recall');

FakeCategory::_newSession();

$t->is($php->countReferences(), 2, '->countReferences() works after a new session has started');

$t->is(FakeCategory::getAllCategories($lucene2), array('HPP'), '::getAllCategories() correctly returns just a culture');

$t->diag('testing clearing');

FakeCategory::clearAll($lucene2);

$t->is($hpp->countReferences(), 0, '::clearAll() can clear a culture');

$t->is($php->countReferences(), 2, '::clearAll() can clear a culture and not touch the others');

FakeCategory::clearAll();

$t->is($php->countReferences(), 0, '::clearAll() can clear all cultures');

FakeCategory::_shutdown();
