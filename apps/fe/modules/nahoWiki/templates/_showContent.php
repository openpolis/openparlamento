<div id="wiki_content">
<?php if (isset($revision)): ?>
  <?php echo $revision->getXHTMLContent() ?>
<?php else: ?>  
  WikiProblema!
<?php endif ?>
</div>
<div id="wiki_edit">
  <?php echo link_to('modifica la descrizione', '@wiki_edit?page='.$page_name) ?>
</div>
<hr/>