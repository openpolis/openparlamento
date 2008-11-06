<?php use_helper('Date', 'I18N', 'nahoWiki') ?>

<h1 class="wiki-title"><?php echo __('History of changes') ?></h1>

<?php if (@$compare): ?>
  <?php echo form_tag('nahoWiki/diff', 'name=diff_form id=diff_form class=wiki-form') ?>
  <?php echo input_hidden_tag('page', $page->getName()) ?>
<?php endif ?>

<table class="wiki-history">
  <thead>
    <tr>
      <?php if (@$compare): ?>
        <th colspan="2"><?php echo __('Compare') ?></th>
      <?php endif ?>
      <th><?php echo __('Revision') ?></th>
      <th><?php echo __('Date') ?></th>
      <th><?php echo __('Author') ?></th>
      <th><?php echo __('Comment') ?></th>
    </tr>
  </thead>
  <tbody>
  <?php $revisions = $page->getRevisions() ?>
  <?php $rev2 = $sf_request->getParameter('revision', @$revisions[0] ? $revisions[0]->getRevision() : null) ?>
  <?php $rev1 = $sf_request->getParameter('oldRevision', @$revisions[1] ? ($rev2 == $revisions[0]->getRevision() ? $revisions[1]->getRevision() : $revisions[0]->getRevision()): null) ?>
  <?php foreach ($revisions as $revision): ?>
    <tr>
      <?php if (@$compare): ?>
        <td><?php echo radiobutton_tag('oldRevision', $revision->getRevision(), $rev1 == $revision->getRevision()) ?></td>
        <td><?php echo radiobutton_tag('revision', $revision->getRevision(), $rev2 == $revision->getRevision()) ?></td>
      <?php endif ?>
      <td><?php echo link_to_wiki(null, $page->getName(), array('revision' => $revision->getRevision())) ?></td>
      <td><?php echo format_datetime($revision->getCreatedAt('U')) ?></td>
      <td><?php echo link_to_wiki_user(null, $revision->getUserName()) ?></td>
      <td><em><?php echo $revision->getComment() ?></em></td>
    </tr>
  <?php endforeach ?>
</table>

<?php if (@$compare): ?>
  <p class="wiki-form-submit"><?php echo submit_tag(__('View changed between selected versions')) ?></p>
  </form>
<?php endif ?>

<?php if (@$revision1 && @$revision2): ?>
  <?php include_partial('diff', array('page' => $page, 'revision1' => $revision1, 'revision2' => $revision2, 'diff' => $diff)) ?>
<?php endif ?>
