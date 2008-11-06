<?php use_helper('I18N', 'nahoWiki') ?>

<p class="wiki-diff-intro"><?php echo __('View below changes from %revision1% to %revision2% :', array(
    '%revision1%' => link_to_wiki(null, $page->getName(), array('revision' => $revision1->getRevision())),
    '%revision2%' => link_to_wiki(null, $page->getName(), array('revision' => $revision2->getRevision())),
  )) ?></p>

<?php if (!trim($diff)): ?>
  <p class="wiki-diff-intro wiki-warning"><?php echo __('There is no difference between the selected revisions') ?></p>
<?php else: ?>
  <pre class="wiki-diff"><?php echo $diff ?></pre>
  <ul class="wiki-diff-links">
    <li><?php echo link_to_diff(__('View reverse diff'), $page->getName(), $revision2->getRevision(), $revision1->getRevision()) ?></li>
    <li><?php echo link_to_raw_diff(__('View raw unified diff'), $page->getName(), $revision1->getRevision(), $revision2->getRevision()) ?></li>
  </ul>
<?php endif ?>