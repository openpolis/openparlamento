<?php if(sfConfig::get('app_sfSimpleBlog_use_media_library', false)): ?>
  <?php use_helper('sfMediaLibrary') ?>
  <?php echo init_media_library() ?>
<?php endif; ?>