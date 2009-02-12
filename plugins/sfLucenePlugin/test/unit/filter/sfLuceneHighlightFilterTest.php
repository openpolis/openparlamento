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
require dirname(__FILE__) . '/../../bin/FakeHighlighter.php';

$t = new lime_test(19, new lime_output_color());

$chain = new sfFilterChain();

$context = sfContext::getInstance();
$response = $context->getResponse();
$request = $context->getRequest();

$context->getI18N()->initialize($context);
$context->getI18N()->setMessageSourceDir(dirname(__FILE__), 'en');

$highlight = new FakeHighlighter();
$highlight->initialize(sfContext::getInstance());

$t->diag('testing validation');

$request->setParameter('h', 'test');

$response->setContent('Hello');
try {
  $highlight->execute($chain);
  $t->fail('highlighter rejects content without a body');
} catch (sfException $e) {
  $t->pass('highlighter rejects content without a body');
}

$response->setContent('<body>Hello');
try {
  $highlight->execute($chain);
  $t->fail('highlighter rejects content without a body ending tag');
} catch (sfException $e) {
  $t->pass('highlighter rejects content without a body ending tag');
}

$response->setContent('Hello</body>');
try {
  $highlight->execute($chain);
  $t->fail('highlighter rejects content without a body starting tag');
} catch (sfException $e) {
  $t->pass('highlighter rejects content without a body starting tag');
}

$response->setContent('<body>Hello</body>');
try {
  $highlight->execute($chain);
  $t->pass('highlighter accepts content with a complete body tag set');
} catch (sfException $e) {
  $t->fail('highlighter accepts content with a complete body tag set');
}

$response->setContent('<body>2 > 1</body>');
try {
  $highlight->execute($chain);
  $t->fail('highlighter rejects content with a carat mismatch');
} catch (sfException $e) {
  $t->pass('highlighter rejects content with a carat mismatch');
}

$response->setContent('<body>I am <b>cool</b>!</body>');
try {
  $highlight->execute($chain);
  $t->pass('highlighter accepts content with a complete body tag set and other carats');
} catch (sfException $e) {
  $t->fail('highlighter accepts content with a complete body tag set and other carats');
}

$t->diag('testing highlighting');

$response->setContent('<body>highlight the keyword</body>');
$request->setParameter('h', 'keyword');
$highlight->execute($chain);
$t->is($response->getContent(), '<body>highlight the <highlighted>keyword</highlighted></body>', 'highlighter highlights a single keyword');

$response->setContent('<body>highlight the keyword</body>');
$request->setParameter('h', 'highlight keyword');
$highlight->execute($chain);
$t->is($response->getContent(), '<body><highlighted>highlight</highlighted> the <highlighted2>keyword</highlighted2></body>', 'highlighter highlights multiple keywords');

$response->setContent('<body>~notice~ keyword</body>');
$request->setParameter('h', 'keyword');
$highlight->execute($chain);
$t->like($response->getContent(), '#<body><keywords><highlighted>keyword</highlighted></keywords><remove>~remove~</remove>#', 'highlighter adds notice string');

$response->setContent('<head></head><body>keyword</body>');
$highlight->execute($chain);
$t->like($response->getContent(), '#<link .*?href=".*?/search\.css".*?/>\n</head>#', 'highlighter adds search stylesheet');

$response->setContent('<head></head><body>~notice~ google search test</body>');
$request->getParameterHolder()->remove('h');
$_SERVER['HTTP_REFERER'] = 'http://www.google.com/search?num=50&hl=en&safe=off&q=google&btnG=Search';
$highlight->execute($chain);

$t->like($response->getContent(), '#<highlighted>google</highlighted> search test#', 'highlighter highlights results from Google');
$t->like($response->getContent(), '#<from><highlighted>Google</highlighted></from><keywords><highlighted>google</highlighted></keywords><remove>~remove~</remove>#', 'highlighter adds correct notice for results from Google');
$t->like($response->getContent(), '#<link .*?href=".*?/search\.css".*?/>\n</head>#', 'highlighter adds search stylesheet for results from Google');

$t->diag('testing conditions when no highlighting occurs');

$request->getParameterHolder()->remove('h');
$_SERVER['HTTP_REFERER'] = null;

$response->setContent('<head></head><body>~notice~ keywords</body>');
$highlight->execute($chain);

$t->unlike($response->getContent(), '#~notice~#', 'highlighter removes notice replacement if there is nothing to do');
$t->unlike($response->getContent(), '#<link .*?href=".*?/search\.css".*?/>\n</head>#', 'highlighter does not add the search stylesheet if there is nothing to do');
$t->is($response->getContent(), '<head></head><body> keywords</body>', 'highlighter leaves result untouched except for notice bang if there is nothing to do');

$t->diag('testing different content types');
$content = '<head></head><body>~notice~ keyword</body>';
$response->setContent($content);
$request->setParameter('h', 'keyword');

$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
$highlight->execute($chain);
$t->is($response->getContent(), $content, 'highlighter skips highlighting on ajax requests');
$_SERVER['HTTP_X_REQUESTED_WITH'] = null;

$response->setHeaderOnly(true);
$highlight->execute($chain);
$t->is($response->getContent(), $content, 'highlighter skips highlighting for header only responses');
$response->setHeaderOnly(false);

$response->setContentType('image/jpeg');
$highlight->execute($chain);
$t->is($response->getContent(), $content, 'highlighter skips highlighting for non X/HTML content');
$response->setContentType('text/html');