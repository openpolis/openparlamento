<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');

$t = new lime_test(55, new lime_output_color());

class myRequest extends sfWebRequest
{
  public $languages = null;
  public $charsets = null;
  public $acceptableContentTypes = null;
}

$context = new sfContext();
$request = sfRequest::newInstance('myRequest');

// ->getLanguages()
$t->diag('->getLanguages()');

$t->is($request->getLanguages(), array(), '->getLanguages() returns an empty array if the client do not send an ACCEPT_LANGUAGE header');

$request->languages = null;
$_SERVER['HTTP_ACCEPT_LANGUAGE'] = '';
$t->is($request->getLanguages(), array(), '->getLanguages() returns an empty array if the client send an empty ACCEPT_LANGUAGE header');

$request->languages = null;
$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-us,en;q=0.5,fr;q=0.3';
$t->is($request->getLanguages(), array('en_US', 'en', 'fr'), '->getLanguages() returns an array with all accepted languages');

// ->getCharsets()
$t->diag('->getCharsets()');

$t->is($request->getCharsets(), array(), '->getCharsets() returns an empty array if the client do not send an ACCEPT_CHARSET header');

$request->charsets = null;
$_SERVER['HTTP_ACCEPT_CHARSET'] = '';
$t->is($request->getCharsets(), array(), '->getCharsets() returns an empty array if the client send an empty ACCEPT_CHARSET header');

$request->charsets = null;
$_SERVER['HTTP_ACCEPT_CHARSET'] = 'ISO-8859-1,utf-8;q=0.7,*;q=0.3';
$t->is($request->getCharsets(), array('ISO-8859-1', 'utf-8', '*'), '->getCharsets() returns an array with all accepted charsets');

// ->getAcceptableContentTypes()
$t->diag('->getAcceptableContentTypes()');

$t->is($request->getAcceptableContentTypes(), array(), '->getAcceptableContentTypes() returns an empty array if the client do not send an ACCEPT header');

$request->acceptableContentTypes = null;
$_SERVER['HTTP_ACCEPT'] = '';
$t->is($request->getAcceptableContentTypes(), array(), '->getAcceptableContentTypes() returns an empty array if the client send an empty ACCEPT header');

$request->acceptableContentTypes = null;
$_SERVER['HTTP_ACCEPT'] = 'text/xml,application/xhtml+xml,application/xml,text/html;q=0.9,text/plain;q=0.8,*/*;q=0.5';
$t->is($request->getAcceptableContentTypes(), array('text/xml', 'application/xml', 'application/xhtml+xml', 'text/html', 'text/plain', '*/*'), '->getAcceptableContentTypes() returns an array with all accepted content types');

// ->getUriPrefix()
$t->diag('->getUriPrefix()');
$_ENV['SERVER_PORT'] = '80';
$_ENV['HTTP_HOST'] = 'symfony-project.org:80';
$t->is($request->getUriPrefix(), 'http://symfony-project.org', '->getUriPrefix() returns no port for standard http port');
$_ENV['HTTP_HOST'] = 'symfony-project.org';
$t->is($request->getUriPrefix(), 'http://symfony-project.org', '->getUriPrefix() works fine with no port in HTTP_HOST');
$_ENV['HTTP_HOST'] = 'symfony-project.org:8088';
$t->is($request->getUriPrefix(), 'http://symfony-project.org:8088', '->getUriPrefix() works for nonstandard http ports');

$_ENV['HTTPS'] = 'on';
$_ENV['SERVER_PORT'] = '443';
$_ENV['HTTP_HOST'] = 'symfony-project.org:443';
$t->is($request->getUriPrefix(), 'https://symfony-project.org', '->getUriPrefix() returns no port for standard https port');
$_ENV['HTTP_HOST'] = 'symfony-project.org';
$t->is($request->getUriPrefix(), 'https://symfony-project.org', '->getUriPrefix() works fine with no port in HTTP_HOST');
$_ENV['HTTP_HOST'] = 'symfony-project.org:8043';
$t->is($request->getUriPrefix(), 'https://symfony-project.org:8043', '->getUriPrefix() works for nonstandard https ports');

// ->splitHttpAcceptHeader()
$t->diag('->splitHttpAcceptHeader()');

$t->is($request->splitHttpAcceptHeader(''), array(), '->splitHttpAcceptHeader() returns an empty array if the header is empty');
$t->is($request->splitHttpAcceptHeader('a,b,c'), array('c', 'b', 'a'), '->splitHttpAcceptHeader() returns an array of values');
$t->is($request->splitHttpAcceptHeader('a,b;q=0.7,c;q=0.3'), array('a', 'b', 'c'), '->splitHttpAcceptHeader() strips the q value');
$t->is($request->splitHttpAcceptHeader('a;q=0.1,b,c;q=0.3'), array('b', 'c', 'a'), '->splitHttpAcceptHeader() sorts values by the q value');

// ->hasFile() ->getFileValues() ->getFileValue()
$t->diag('->hasFile() ->getFileValues() ->getFileValue()');
$_FILES = array(
  'file' => array(
    'name' => 'test1.txt',
    'type' => 'text/plain',
    'tmp_name' => '/tmp/test1.txt',
    'error' => 0,
    'size' => 100,
  ),
  'file1' => array(
    'name' => 'test2.txt',
    'type' => 'text/plain',
    'tmp_name' => '/tmp/test1.txt',
    'error' => 0,
    'size' => 200,
  ),
);

$expected = array(
    'name' => 'test1.txt',
    'type' => 'text/plain',
    'tmp_name' => '/tmp/test1.txt',
    'error' => 0,
    'size' => 100,
  );

$request->initialize($context);
$t->is($request->hasFile('file'), true, '->hasFile() return true if the file exists');
$t->is($request->hasFile('foo'), false, '->hasFile() return false if the file does not exists');
$t->is_deeply($request->getFileValues('file'), $expected, '->getFilesValues() return an array of file information');
$t->is($request->getFileValue('file', 'name'), 'test1.txt', '->getFileValue() return a correct file information');
$t->is($request->getFileValue('file', 'size'), 100, '->getFileValue() return a correct file information');
$t->is($request->getFileValues('foo'), null, '->getFileValues() return null if the file does not exists');
$t->is($request->getFileValue('foo', 'bar'), null, '->getFileValue() return null if the file does not exists');
$t->is($request->getFileValue('file', 'bar'), null, '->getFileValue() return null if the key does not exists');

$_FILES = array(
  'article' => array(
    'name' => array(
      'file1' => 'test1.txt',
      'file2' => 'test2.txt',
    ),
    'type' => array(
      'file1' => 'text/plain',
      'file2' => 'text/plain',
    ),
    'tmp_name' => array(
      'file1' => '/tmp/test1.txt',
      'file2' => '/tmp/test2.txt',
    ),
    'error' => array(
      'file1' => 0,
      'file2' => 0,
    ),
    'size' => array(
      'file1' => 100,
      'file2' => 200,
    ),
  ),
);

$request->initialize($context);
$t->is($request->hasFile('article[file1]'), true, '->hasFile() return true if the file exists');
$t->is($request->hasFile('foo'), false, '->hasFile() return false if the file does not exists');
$t->is_deeply($request->getFileValues('article[file1]'), $expected, '->getFilesValues() return an array of file information');
$t->is($request->getFileValue('article[file1]', 'name'), 'test1.txt', '->getFileValue() return a correct file information');
$t->is($request->getFileValue('article[file1]', 'size'), 100, '->getFileValue() return a correct file information');
$t->is($request->getFileValues('foo[bar]'), null, '->getFileValues() return null if the file does not exists');
$t->is($request->getFileValue('foo[bar]', 'bar'), null, '->getFileValue() return null if the file does not exists');
$t->is($request->getFileValue('article[file1]', 'bar'), null, '->getFileValue() return null if the key does not exists');

$_FILES = array (
  'book' => array (
    'name' => array (
      'article' => array (
        'file1' => 'test1.txt',
        'file2' => 'test2.txt',
      ),
    ),
    'type' => array (
      'article' => array (
        'file1' => 'text/plain',
        'file2' => 'text/plain',
      ),
    ),
    'tmp_name' => array (
      'article' => array (
        'file1' => '/tmp/test1.txt',
        'file2' => '/tmp/test2.txt',
      ),
    ),
    'error' => array (
      'article' => array (
        'file1' => 0,
        'file2' => 0,
      ),
    ),
    'size' => array (
      'article' => array (
        'file1' => 100,
        'file2' => 200,
      ),
    )
  )
);

$request->initialize($context);
$t->is($request->hasFile('book[article][file1]'), true, '->hasFile() return true if the file exists');
$t->is($request->hasFile('foo'), false, '->hasFile() return false if the file does not exists');
$t->is_deeply($request->getFileValues('book[article][file1]'), $expected, '->getFilesValues() return an array of file information');
$t->is($request->getFileValue('book[article][file1]', 'name'), 'test1.txt', '->getFileValue() return a correct file information');
$t->is($request->getFileValue('book[article][file1]', 'size'), 100, '->getFileValue() return a correct file information');

$_FILES = array (
  'book' =>
  array (
    'name' =>
    array (
      'article' =>
      array (
        0 => 'test1.txt',
        1 => 'test2.txt',
      ),
    ),
    'type' =>
    array (
      'article' =>
      array (
        0 => 'text/plain',
        1 => 'text/plain',
      ),
    ),
    'tmp_name' =>
    array (
      'article' =>
      array (
        0 => '/tmp/test1.txt',
        1 => '/tmp/test2.txt',
      ),
    ),
    'error' =>
    array (
      'article' =>
      array (
        0 => 0,
        1 => 0,
      ),
    ),
    'size' =>
    array (
      'article' =>
      array (
        0 => 100,
        1 => 200,
      ),
    ),
  ),
);

$request->initialize($context);
$t->is($request->hasFile('book[article][0]'), true, '->hasFile() return true if the file exists');
$t->is($request->hasFile('foo'), false, '->hasFile() return false if the file does not exists');
$t->is_deeply($request->getFileValues('book[article][0]'), $expected, '->getFilesValues() return an array of file information');
$t->is($request->getFileValue('book[article][0]', 'name'), 'test1.txt', '->getFileValue() return a correct file information');
$t->is($request->getFileValue('book[article][0]', 'size'), 100, '->getFileValue() return a correct file information');


$_FILES = array (
  'book' =>
  array (
    'name' =>
    array (
      'article' =>
      array (
        0 => 'test1.txt',
        1 => 'test2.txt',
      ),
    ),
    'type' =>
    array (
      'article' =>
      array (
        0 => 'text/plain',
        1 => 'text/plain',
      ),
    ),
    'tmp_name' =>
    array (
      'article' =>
      array (
        0 => '/tmp/test1.txt',
        1 => '/tmp/test2.txt',
      ),
    ),
    'error' =>
    array (
      'article' =>
      array (
        0 => 0,
        1 => 0,
      ),
    ),
    'size' =>
    array (
      'article' =>
      array (
        0 => 100,
        1 => 200,
      ),
    ),
  ),
);

$request->initialize($context);
$t->is($request->hasFile('book[article][0]'), true, '->hasFile() return true if the file exists');
$t->is($request->hasFile('foo'), false, '->hasFile() return false if the file does not exists');
$t->is_deeply($request->getFileValues('book[article][0]'), $expected, '->getFilesValues() return an array of file information');
$t->is($request->getFileValue('book[article][0]', 'name'), 'test1.txt', '->getFileValue() return a correct file information');
$t->is($request->getFileValue('book[article][0]', 'size'), 100, '->getFileValue() return a correct file information');

$_FILES = array(
  'article' => array(
    'name' => array(
      0 => 'test1.txt',
      1 => 'test2.txt',
    ),
    'type' => array(
      0 => 'text/plain',
      1 => 'text/plain',
    ),
    'tmp_name' => array(
      0 => '/tmp/test1.txt',
      1 => '/tmp/test2.txt',
    ),
    'error' => array(
      0 => 0,
      1 => 0,
    ),
    'size' => array(
      0 => 100,
      1 => 200,
    ),
  ),
);

$request->initialize($context);
$t->is($request->hasFile('article[0]'), true, '->hasFile() return true if the file exists');
$t->is($request->hasFile('foo'), false, '->hasFile() return false if the file does not exists');
$t->is_deeply($request->getFileValues('article[0]'), $expected, '->getFilesValues() return an array of file information');
$t->is($request->getFileValue('article[0]', 'name'), 'test1.txt', '->getFileValue() return a correct file information');
$t->is($request->getFileValue('article[0]', 'size'), 100, '->getFileValue() return a correct file information');
