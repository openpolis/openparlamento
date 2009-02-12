<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * symfony adapter for Zend_Search_Lucene_Storage_File_Filesystem
 * @package sfLucenePlugin
 * @subpackage Addon
 */
class sfLuceneFileStorage extends Zend_Search_Lucene_Storage_File_Filesystem
{
  public function __construct($filename, $mode = 'r+b')
  {
    parent::__construct($filename, $mode);

    if (file_exists($filename) && substr(sprintf('%o', fileperms($filename)), -4) != '0777')
    {
      if (!@chmod($filename, 0777))
      {
        throw new sfException(sprintf('Unable to chmod file "%s".  Permissions are already %o', $filename, fileperms($filename)));
      }
    }
  }
}