<ul class="wiki-actions">
  <?php if ($canView): ?>
    <li class="wiki-action-view<?php echo $action == 'view' ? ' active' : '' ?>"><?php 
      echo link_to(__('View'), 'nahoWiki/view?' . $uriParams) ?></li>
    <li class="wiki-action-edit<?php echo $action == 'edit' ? ' active' : '' ?>"><?php 
      echo link_to(__($canEdit ? 'Edit' : 'View source'), 'nahoWiki/edit?' . $uriParams) ?></li>
    <li class="wiki-action-history<?php echo $action == 'history' || $action == 'diff' ? ' active' : '' ?>"><?php 
      echo link_to(__('History'), 'nahoWiki/history?' . $uriParams) ?></li>
  <?php endif ?>
  <li class="wiki-action-index<?php echo $action == 'browse' ? ' active' : '' ?>"><?php 
      echo link_to(__('Index'), 'nahoWiki/browse?' . $uriParams) ?></li>
</ul>