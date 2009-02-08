<ul class="second-level-tabs float-container">
  <?php if ($canView): ?>
    <li class="<?php echo $action == 'edit' ? 'current' : '' ?>"><?php 
    echo link_to(__($canEdit ? '<h5>Modifica la descrizione dell\'atto</h5>' : '<h5>Markdown source</h5>'), 'nahoWiki/edit?' . $uriParams) ?></li>
    <li class="<?php echo $action == 'history' || $action == 'diff' ? 'current' : '' ?>"><?php 
    echo link_to(__('<h5>Cronologia delle modifiche</h5>'), 'nahoWiki/history?' . $uriParams) ?></li>
   <?php endif ?>
</ul>