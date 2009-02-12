<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * symfony adapter for Zend_Search_Lucene_Storage_Directory_Filesystem to keep file
 * permissions sanes.
 * @package sfLucenePlugin
 * @subpackage Addon
 */
class sfLuceneDirectoryStorage extends Zend_Search_Lucene_Storage_Directory_Filesystem
{
    public function __construct($path)
    {
      
      parent::__construct($path);

      if (is_dir($path) && substr(sprintf('%o', fileperms($path)), -4) != '0777')
      {
        if (!@chmod($path, 0777))
        {
          ini_set('track_errors', $trackErrors);
          throw new sfException(sprintf('Unable to chmod file "%s".  Permissions are already %o', $path, fileperms($path)));
        }
      }
    }

    /**
     * Creates a new, empty file in the directory with the given $filename.
     *
     * @param string $filename
     * @return Zend_Search_Lucene_Storage_File
     */
    public function createFile($filename)
    {
        if (isset($this->_fileHandlers[$filename])) {
            $this->_fileHandlers[$filename]->close();
        }
        unset($this->_fileHandlers[$filename]);
        $this->_fileHandlers[$filename] = new sfLuceneFileStorage($this->_dirPath . '/' . $filename, 'w+b');

        global $php_errormsg;
        $trackErrors = ini_get('track_errors'); ini_set('track_errors', '1');

        if (file_exists($this->_dirPath . '/' . $filename) && substr(sprintf('%o', fileperms($this->_dirPath . '/' . $filename)), -4) != '0777')
        {
          if (!@chmod($this->_dirPath . '/' . $filename, 0777))
          {
            ini_set('track_errors', $trackErrors);
            throw new sfException(sprintf('Unable to chmod file "%s".  Permissions are already %o', $this->_dirPath . '/' . $filename, fileperms($this->_dirPath . '/' . $filename)));
          }
        }

        ini_set('track_errors', $trackErrors);

        return $this->_fileHandlers[$filename];
    }

    /**
     * Returns a Zend_Search_Lucene_Storage_File object for a given $filename in the directory.
     *
     * If $shareHandler option is true, then file handler can be shared between File Object
     * requests. It speed-ups performance, but makes problems with file position.
     * Shared handler are good for short atomic requests.
     * Non-shared handlers are useful for stream file reading (especial for compound files).
     *
     * @param string $filename
     * @param boolean $shareHandler
     * @return Zend_Search_Lucene_Storage_File
     */
    public function getFileObject($filename, $shareHandler = true)
    {
        $fullFilename = $this->_dirPath . '/' . $filename;

        if (!$shareHandler) {
            return new sfLuceneFileStorage($fullFilename);
        }

        if (isset( $this->_fileHandlers[$filename] )) {
            $this->_fileHandlers[$filename]->seek(0);
            return $this->_fileHandlers[$filename];
        }

        $this->_fileHandlers[$filename] = new sfLuceneFileStorage($fullFilename);
        return $this->_fileHandlers[$filename];
    }
}