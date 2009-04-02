<?php if ($currentDir != ''): ?>
  <div class="assetImage"><?php echo link_to(image_tag('/sfMediaLibraryPlugin/images/up', array('alt' => '..', 'title' => '..', 'size' => '64x64')), 'sfMediaLibrary/'.$sf_context->getActionName().'?dir='.$parentDir) ?>
    <p class="assetComment">&raquo;&nbsp;..<?php if ($is_file or ($sf_context->getActionName() === 'index')): ?>
      <br />&nbsp;
    <?php endif; ?></p>
  </div>
<?php endif; ?>
<?php $count = 0; foreach ($dirs as $dir): $count++ ?>
  <div id="block_<?php echo $count ?>" class="assetImage">
    <?php include_partial('sfMediaLibrary/block', array(
      'name'         => $dir,
      'current_path' => $currentDir,
      'type'         => 'folder',
      'info'         => array(),
      'count'        => $count,
      'is_file'      => $is_file,
    )) ?>
  </div>
<?php endforeach; ?>
