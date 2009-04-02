<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-200000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  </head>
  <body>
    <?php use_helper('Javascript', 'I18N') ?>
    <?php echo javascript_tag("
    function setFileSrc(src)
    {
      opener.sfMediaLibrary.fileBrowserReturn(src);
      window.close();
    }
    ") ?>
    <div id="sf_asset_container">
      <h1><?php echo __('Media library (%1%)', array('%1%' => $current_dir_slash), 'sfMediaLibrary') ?></h1>
      <div id="sf_asset_content_popup">
        <?php include_partial('sfMediaLibrary/dirs', array('dirs' => $dirs, 'currentDir' => $currentDir, 'parentDir' => $parentDir, 'is_file' => (count($files) > 0))) ?>
        <?php include_partial('sfMediaLibrary/files', array('files' => $files, 'currentDir' => $currentDir, 'webAbsCurrentDir' => $webAbsCurrentDir, 'count' => count($dirs))) ?>
      </div>
    </div>
  </body>
</html>