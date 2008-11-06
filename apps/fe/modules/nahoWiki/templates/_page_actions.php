<ul class="wiki-actions">
  <?php if ($canView): ?>
    <li class="wiki-action-edit<?php echo $action == 'edit' ? ' active' : '' ?>"><?php 
      echo link_to(__($canEdit ? 'Edit' : 'Markdown source'), 'nahoWiki/edit?' . $uriParams) ?></li>
    <li class="wiki-action-history<?php echo $action == 'history' || $action == 'diff' ? ' active' : '' ?>"><?php 
      echo link_to(__('History'), 'nahoWiki/history?' . $uriParams) ?></li>
  <?php endif ?>
  <li class="wiki-action-index"><?php 
      echo link_to(__('Back to content'), $sf_user->getAttribute('referer', '@homepage')) ?></li>
</ul>