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

$lucene = FakeLucene::getInstance('lucene', 'en');

$t = new lime_test(21, new lime_output_color());

$t->diag('testing constructor');

try {
  $results = new sfLucenePager('a', $lucene);
  $t->fail('__construct() rejects a non-array');
} catch (Exception $e) {
  $t->pass('__construct() rejects a non-array');
}

try {
  $results = new sfLucenePager(range(0, 1000), $lucene);
  $t->pass('__construct() accepts an array');
} catch (Exception $e) {
  $t->fail('__construct() accepts an array');
}

$t->diag('testing basic pagination functions');

try {
  $results->setPage(2);
  $t->pass('->setPage() accepts a integer page');
} catch (Exception $e) {
  $t->fail('->setPage() accepts a integer page');
}

try {
  $results->setMaxPerPage(10);
  $t->pass('->setMaxPerPage() accepts an integer per page');
} catch (Exception $e) {
  $t->fail('->setMaxPerPage() accepts an integer per page');
}

$t->is($results->getPage(), 2, '->getPage() returns current page');
$t->is($results->getMaxPerPage(), 10, '->getMaxPerPage() returns the max per page');
$t->is($results->getNbResults(), 1001, '->getNbResults() returns the total number of results');
$t->ok($results->haveToPaginate(), '->haveToPaginate() returns correct value');

$t->diag('testing ->getResults()');

$t->is_deeply($results->getResults()->toArray(), range(10, 20), '->getResults() returns the correct range');
$results->setPage(3);
$t->is_deeply($results->getResults()->toArray(), range(20, 30), '->getResults() returns the correct range after page change');

$t->diag('testing page numbers');

$t->is($results->getFirstPage(), 1, '->getFirstPage() returns 1 as first page');
$t->is($results->getLastPage(), 101, '->getLastPage() returns the last page in the range');

$t->is($results->getNextPage(), 4, '->getNextPage() returns the next page');
$results->setPage(101);
$t->is($results->getNextPage(), 101, '->getNextPage() returns last page if at end');
$results->setPage(4);

$t->is($results->getPreviousPage(), 3, '->getPreviousPage() returns the previous page');
$results->setPage(1);
$t->is($results->getPreviousPage(), 1, '->getPreviousPage() returns the first page if at start');
$results->setPage(4);

$t->diag('testing page indices');
$t->is($results->getFirstIndice(), 31, '->getFirstIndice() returns correct first indice in results');
$t->is($results->getLastIndice(), 40, '->getLastIndice() returns correct last indice in result');

$t->diag('testing link generator');
$t->is($results->getLinks(5), range(2, 6), '->getLinks() returns the correct link range');

$results->setPage(1);
$t->is($results->getLinks(5), range(1, 5), '->getLinks() returns correct link range when at start of index');

$results->setPage(101);
$t->is($results->getLinks(5), range(97, 101), '->getLinks() returns link range when at end of index');