<?php use_helper('I18N', 'nahoWiki') ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="evidence-box">
   <h5 class="subsection-grey">
   <!--//<?php echo link_to_diff(__('visualizza revisioni invertite'),$page->getName(), $revision2->getRevision(), $revision1->getRevision(), array("class" => "float-right small")) ?> -->
    <?php echo __('modifiche da %revision1% a %revision2% :', array(
    '%revision1%' => link_to_wiki(null, $page->getName(), array('revision' => $revision1->getRevision())),
    '%revision2%' => link_to_wiki(null, $page->getName(), array('revision' => $revision2->getRevision())),
     )) ?>
    </h5>
     

<?php if (!trim($diff)): ?>
  <p class="wiki-diff-intro wiki-warning"><?php echo __('Non ci sono differenze tra le versioni selezionate') ?></p>
<?php else: ?>
  <pre class="wiki-diff"><?php echo $diff ?></pre>
<?php endif ?>

</div> 