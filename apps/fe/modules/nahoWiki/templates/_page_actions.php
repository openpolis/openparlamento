<ul class="wiki-actions">
  <?php if ($canView): ?>
    <li class="wiki-action-view<?php echo $action == 'view' ? ' active' : '' ?>"><?php 
      echo link_to(__('Visualizza'), 'nahoWiki/view?' . $uriParams) ?></li>
    <li class="wiki-action-edit<?php echo $action == 'edit' ? ' active' : '' ?>"><?php 
      echo link_to(__($canEdit ? 'Modifica' : 'Sorgente markdown'), 'nahoWiki/edit?' . $uriParams) ?></li>
    <li class="wiki-action-history<?php echo $action == 'history' || $action == 'diff' ? ' active' : '' ?>"><?php 
      echo link_to(__('Cronologia'), 'nahoWiki/history?' . $uriParams) ?></li>
  <?php endif ?>
  <li class="wiki-action-index"><?php 
      echo link_to(__('Torna alla scheda'), $sf_user->getAttribute('referer', '@homepage')) ?></li>
</ul>