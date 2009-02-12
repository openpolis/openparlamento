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

require dirname(__FILE__) . '/../bootstrap/unit.php';

$t = new lime_test(2, new lime_output_color());

function filter_callback($input)
{
  return preg_match('#/plugins/sfLucenePlugin/lib/vendor/Zend/Search/Lucene/#', $input);
}
function zend_loaded()
{
  $files = get_included_files();
  $files = array_filter($files, 'filter_callback');

  return count($files) == 0;
}

$forum = new Forum;
$t->ok(zend_loaded(), 'Zend libraries were not loaded when just reading from a model');

$forum->setTitle('test');
$forum->saveIndex();

$t->ok(!zend_loaded(), 'Zend libraries were loaded when writing to the index');

$forum->deleteIndex();