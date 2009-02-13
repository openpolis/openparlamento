<div class="wiki-box-edit">
<?php if ($sf_user->isAuthenticated()): ?>
  <?php echo link_to('modifica', '@wiki_edit?page='.$page_name) ?>
<?php else: ?>    
  <?php echo link_to('entra per modificare', '@sf_guard_signin') ?>
<?php endif ?>
</div>
<div style="clear:both"></div>
<div class="wiki-box">

  <div class="wiki-box-content">
    <?php if (isset($revision)): ?>
      <?php echo $revision->getXHTMLContent() ?>
    <?php else: ?>  
      WikiProblema!
    <?php endif ?>
  </div>		
  
</div>
