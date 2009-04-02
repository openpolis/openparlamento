<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 1949 2006-09-05 14:40:20Z fabien $
 */
class BasesfMediaLibraryActions extends sfActions
{
  protected
    $uploadDir     = '',
    $uploadDirName = '',
    $useThumbnails = false,
    $thumbnailsDir = '';

  public function preExecute()
  {
    if (sfConfig::get('app_sfMediaLibrary_use_thumbnails', true) && class_exists('sfThumbnail'))
    {
      $this->useThumbnails = true;
      $this->thumbnailsDir = sfConfig::get('app_sfMediaLibrary_thumbnails_dir', 'thumbnail');
    }

    $this->uploadDirName = sfConfig::get('app_sfMediaLibrary_upload_dir', str_replace(sfConfig::get('sf_web_dir'), '', sfConfig::get('sf_upload_dir')).'/assets');
    $this->uploadDir     = sfConfig::get('sf_web_dir').'/'.$this->uploadDirName;
  }

  public function executeIndex()
  {
    $currentDir = $this->dot2slash($this->getRequestParameter('dir'));
    $this->currentDir = $this->getRequestParameter('dir');
    $this->current_dir_slash = $currentDir.'/';
    $this->webAbsCurrentDir = $this->getRequest()->getRelativeUrlRoot().'/'.$this->uploadDirName.'/'.$currentDir;
    $this->absCurrentDir = $this->uploadDir.'/'.$currentDir;

    $this->forward404Unless(is_dir($this->absCurrentDir));

    // directories
    $dirsQuery = sfFinder::type('dir')->maxdepth(0)->prune('.*')->discard('.*')->relative();
    if ($this->useThumbnails)
    {
      $dirsQuery = $dirsQuery->discard($this->thumbnailsDir);
    }
    $dirs = $dirsQuery->in($this->absCurrentDir);
    sort($dirs);
    $this->dirs = $dirs;

    // files, with stats
    $files = sfFinder::type('file')->maxdepth(0)->prune('.*')->discard('.*')->relative()->in($this->absCurrentDir);
    sort($files);
    $infos = array();
    foreach ($files as $file)
    {
      $ext = substr($file, strpos($file, '.') - strlen($file) + 1);
      if (!$this->getRequestParameter('images_only') || $this->isImage($ext))
      {
        $infos[$file] = $this->getInfo($file);
      }
    }
    $this->files = $infos;

    // parent dir
    $tmp = explode(' ', $this->currentDir);
    array_pop($tmp);
    $this->parentDir = implode(' ', $tmp);
  }

  protected function isImage($ext)
  {
    return in_array(strtolower($ext), array('png', 'jpg', 'gif'));
  }

  public function executeChoice()
  {
    $this->executeIndex();
  }

  public function executeRename()
  {
    $currentDir = $this->dot2slash($this->getRequestParameter('current_path'));
    $this->currentDir = $this->getRequestParameter('current_path');
    $type = $this->getRequestParameter('type');
    $this->count = $this->getRequestParameter('count');
    $this->webAbsCurrentDir = '/'.$this->uploadDirName.'/'.$currentDir;
    $absCurrentDir = $this->uploadDir.'/'.$currentDir;
    
    $this->forward404Unless(is_dir($absCurrentDir));

    $name = $this->getRequestParameter('name');
    $new_name = $this->getRequestParameter('new_name');
    if ($type === 'folder')
    {
      $new_name = $this->sanitizeDir($new_name);
      $this->forward404Unless(is_dir($absCurrentDir.'/'.$name));
    }
    else
    {
      $new_name = $this->sanitizeFile($new_name);
      $this->forward404Unless(is_file($absCurrentDir.'/'.$name));
    }

    @rename($absCurrentDir.'/'.$name, $absCurrentDir.'/'.$new_name);

    if ($this->useThumbnails && ($type === 'file') && file_exists($absCurrentDir.'/'.$this->thumbnailsDir.'/'.$name))
    {
      @rename($absCurrentDir.'/'.$this->thumbnailsDir.'/'.$name, $absCurrentDir.'/'.$this->thumbnailsDir.'/'.$new_name);
    }

    $this->absCurrentDir = $absCurrentDir;
    $this->info = array();
    if (is_dir($absCurrentDir.'/'.$new_name) and ($type === 'folder'))
    {
      $this->name = $new_name;
    }
    else if (is_file($absCurrentDir.'/'.$new_name) and ($type === 'file'))
    {
      $this->name = $new_name;
      $this->info = $this->getInfo($new_name);
    }
    else
    {
      $this->name = $name;
      $this->info = $this->getInfo($name);
    }

    $this->type = $type;
  }

  protected function getInfo($filename)
  {
    $info = array();
    $info['ext']  = substr($filename, strpos($filename, '.') - strlen($filename) + 1);
    $stats = stat($this->absCurrentDir.'/'.$filename);
    $info['size'] = $stats['size'];
    $info['thumbnail'] = true;
    if ($this->isImage($info['ext']))
    {
      if ($this->useThumbnails && is_readable(sfConfig::get('sf_web_dir').$this->webAbsCurrentDir.'/'.$this->thumbnailsDir.'/'.$filename))
      {
        $info['icon'] = $this->webAbsCurrentDir.'/'.$this->thumbnailsDir.'/'.$filename;
      }
      else
      {
        $info['icon'] = $this->webAbsCurrentDir.'/'.$filename;
        $info['thumbnail'] = false;
      }
    }
    else
    {
      if (is_readable(sfConfig::get('sf_web_dir').'/sfMediaLibraryPlugin/images/'.$info['ext'].'.png'))
      {
        $info['icon'] = '/sfMediaLibraryPlugin/images/'.$info['ext'].'.png';
      }
      else
      {
        $info['icon'] = '/sfMediaLibraryPlugin/images/unknown.png';
      }
    }

    return $info;
  }

  public function executeUpload()
  {
    $currentDir = $this->dot2slash($this->getRequestParameter('current_dir'));
    $webAbsCurrentDir = '/'.$this->uploadDirName.'/'.$currentDir;
    $absCurrentDir = $this->uploadDir.'/'.$currentDir;

    $this->forward404Unless(is_dir($absCurrentDir));

    $filename = $this->sanitizeFile($this->getRequest()->getFileName('file'));
    $info['ext']  = substr($filename, strpos($filename, '.') - strlen($filename) + 1);

    if ($this->isImage($info['ext']) && $this->useThumbnails)
    {
      if (!is_dir($absCurrentDir.'/'.$this->thumbnailsDir))
      {
        // If the thumbnails directory doesn't exist, create it now
        $old = umask(0000);
        @mkdir($absCurrentDir.'/'.$this->thumbnailsDir, 0777, true);
        umask($old);
      }
      $thumbnail = new sfThumbnail(64, 64);
      $thumbnail->loadFile($this->getRequest()->getFilePath('file'));
      $thumbnail->save($absCurrentDir.'/'.$this->thumbnailsDir.'/'.$filename);
    }
    $this->getRequest()->moveFile('file', $absCurrentDir.'/'.$filename);

    $this->redirect('sfMediaLibrary/index?dir='.$this->getRequestParameter('current_dir'));
  }

  public function executeDelete()
  {
    $currentDir = $this->dot2slash($this->getRequestParameter('current_path'));
    $currentFile = $this->getRequestParameter('name');
    $absCurrentFile = $this->uploadDir.'/'.$currentDir.'/'.$currentFile;

    $this->forward404Unless(is_readable($absCurrentFile));

    unlink($absCurrentFile);

    if ($this->useThumbnails)
    {
      $absThumbnailFile = $this->uploadDir.'/'.$currentDir.'/'.$this->thumbnailsDir.'/'.$currentFile;
      if (is_readable($absThumbnailFile))
      {
        unlink($absThumbnailFile);
      }
    }

    $this->redirect('sfMediaLibrary/index?dir='.$this->getRequestParameter('current_path'));
  }

  public function executeMkdir()
  {
    $currentDir = $this->dot2slash($this->getRequestParameter('current_dir'));
    $dirName = $this->sanitizeDir($this->getRequestParameter('name'));
    $absCurrentDir = $this->uploadDir.'/'.(empty($currentDir) ? '' : $currentDir.'/').$dirName;

    $old = umask(0000);
    @mkdir($absCurrentDir, 0777);
    if ($this->useThumbnails)
    {
      @mkdir($absCurrentDir.'/'.$this->thumbnailsDir, 0777);
    }
    umask($old);

    $this->redirect('sfMediaLibrary/index?dir='.$this->getRequestParameter('current_dir'));
  }

  public function executeRmdir()
  {
    $currentDir = $this->dot2slash('.'.$this->getRequestParameter('current_path'));
    $absCurrentDir = $this->uploadDir.'/'.$currentDir.'/'.$this->getRequestParameter('name');

    $this->forward404Unless(is_dir($absCurrentDir));

    if($this->useThumbnails && is_readable($absCurrentDir.'/'.$this->thumbnailsDir))
    {
      rmdir($absCurrentDir.'/'.$this->thumbnailsDir);
    }

    rmdir($absCurrentDir);

    $this->redirect('sfMediaLibrary/index?dir='.$this->getRequestParameter('current_path'));
  }

  protected function dot2slash($txt)
  {
    return preg_replace('#[\+\s]+#', '/', $txt);
  }

  protected function slash2dot($txt)
  {
    return preg_replace('#/+#', '+', $txt);
  }

  protected function sanitizeDir($dir)
  {
    return preg_replace('/[^a-z0-9_-]/i', '_', $dir);
  }

  protected function sanitizeFile($file)
  {
    return preg_replace('/[^a-z0-9_\.-]/i', '_', $file);
  }
}
