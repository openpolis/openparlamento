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

class FakeCategory extends sfLuceneCategory
{
  static protected $_original_contents = null;

  static public function _setup()
  {
    if (file_exists(self::getLocation()))
    {
      self::$_original_contents = file_get_contents(self::getLocation());

      unlink(self::getLocation());
    }
  }

  static public function _shutdown()
  {
    if (self::$_original_contents)
    {
      file_put_contents(self::getLocation(), self::$_original_contents);
    }
    else
    {
      unlink(self::getLocation());
    }
  }

  static public function _newSession()
  {
    self::$list = array();

    self::readList();
  }

  static public function _getLocation()
  {
    return self::getLocation();
  }
}
