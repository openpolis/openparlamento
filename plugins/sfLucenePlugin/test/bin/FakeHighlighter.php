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

class FakeHighlighter extends sfLuceneHighlightFilter
{
  protected $testMode = true;

  public function __construct()
  {
    $this->initialize(sfContext::getInstance());
  }

  protected function warn($msg)
  {
    throw new sfException($msg);
  }

  protected function shouldCheckReferer()
  {
    return true;
  }
  protected function getHighlightQs()
  {
    return 'h';
  }
  protected function getNoticeTag()
  {
    return '~notice~';
  }
  protected function getHighlightStrings()
  {
    return array('<highlighted>%s</highlighted>', '<highlighted2>%s</highlighted2>');
  }
  protected function getNoticeRefererString()
  {
    return '<from>%from%</from><keywords>%keywords%</keywords><remove>%remove%</remove>';
  }
  protected function getNoticeString()
  {
    return '<keywords>%keywords%</keywords><remove>%remove%</remove>';
  }
  protected function getRemoveString()
  {
    return '~remove~';
  }

  protected function getCssLocation()
  {
    return 'search.css';
  }
}