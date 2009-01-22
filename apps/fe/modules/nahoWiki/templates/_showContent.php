<div class="wiki-box">
<?php echo link_to('modifica', '@wiki_edit?page='.$page_name, 'class=wiki-box-edit action') ?>

<div class="wiki-box-content">

<?php if (isset($revision)): ?>
  <?php echo $revision->getXHTMLContent() ?>
<?php else: ?>  
  WikiProblema!
<?php endif ?>

</div>		
<a href="#" class="wiki-box-read action">leggi tutto</a>
</div>
