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

define('SF_LUCENE_UNIT_TEST', true);

/**
  * A fake lucene model that handles our test config.
  *
  * @package sfLucenePlugin
  * @subpackage Test
  */
class FakeLucene extends sfLucene
{
  static protected $getConfigPassoff = array('FakeLucene', 'getTestConfig');

  static public function getTestConfig()
  {
    return array('lucene' => array (
      'models' =>
      array (
        'Forum' =>
        array (
          'fields' =>
          array (
            'id' =>
            array (
              'type' => 'unindexed',
              'boost' => 1,
            ),
            'title' =>
            array (
              'type' => 'text',
              'boost' => 2,
            ),
            'description' =>
            array (
              'type' => 'text',
              'boost' => 1,
            ),
          ),
          'title' => 'title',
          'description' => 'description',
          'categories' => 'Forum',
          'route' => 'forum/showForum?id=%id%',
          'partial' => NULL,
          'indexer' => NULL,
        ),
      ),
      'index' =>
      array (
        'encoding' => 'UTF-8',
        'cultures' =>
        array (
          0 => 'en',
          1 => 'fr',
        ),
        'stop_words' =>
        array (
          0 => 'and',
          1 => 'the',
        ),
        'short_words' => 2,
        'analyzer' => 'utf8num',
        'case_sensitive' => false,
        'mb_string' => true,
      ),
      'interface' =>
      array (
        'categories' => true,
        'advanced' => true,
      ),
    ));
  }

  static public function _getForumArray()
  {
    return array (
        'fields' =>
        array (
          'id' =>
          array (
            'type' => 'unindexed',
            'boost' => 1,
          ),
          'title' =>
          array (
            'type' => 'text',
            'boost' => 2,
          ),
          'description' =>
          array (
            'type' => 'text',
            'boost' => 1,
          ),
        ),
        'title' => 'title',
        'description' => 'description',
        'categories' => 'Forum',
        'route' => 'forum/showForum?id=%id%',
        'partial' => NULL,
        'indexer' => NULL
      );
  }
}
