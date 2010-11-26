<?php use_helper('Date', 'I18N', 'nahoWiki') ?>

<p>In questa pagina puoi visionare le differenze tra le diverse versioni della descrizione. </p>
<p>&nbsp;</p>


<?php if (@$compare): ?>
  <?php echo form_tag('nahoWiki/diff', 'name=diff_form id=diff_form class=commit') ?>
  <?php echo input_hidden_tag('page', $page->getName()) ?>
<?php endif ?>

<div class="evidence-box">

 <h5 class="subsection">seleziona due versioni da comparare</h5>

 <table class="disegni-decreti wiki-history">
  <thead>
    <tr>
      <?php if (@$compare): ?>
        <th scope="col"><?php echo __('Compara') ?></th>
      <?php endif ?>
      <th scope="col"><?php echo __('Versione') ?></th>
      <th scope="col"><?php echo __('data e ora') ?></th>
      <th scope="col"><?php echo __('autore') ?></th>
    </tr>
  </thead>
  <tbody>
  <?php $revisions = $page->getRevisions() ?>
  <?php $rev2 = $sf_request->getParameter('revision', @$revisions[0] ? $revisions[0]->getRevision() : null) ?>
  <?php $rev1 = $sf_request->getParameter('oldRevision', @$revisions[1] ? ($rev2 == $revisions[0]->getRevision() ? $revisions[1]->getRevision() : $revisions[0]->getRevision()): null) ?>
  <?php $ciclo=0; ?>
  <?php foreach ($revisions as $revision): ?>
    <?php $ciclo=$ciclo+1; ?>
    <tr class="<?php echo fmod($ciclo,2)==0 ? 'even' : 'odd' ?>">
      <?php if (@$compare): ?>
        <td><?php echo radiobutton_tag('oldRevision', $revision->getRevision(), $rev1 == $revision->getRevision(),array("class"=>"revision")) ?>
        <?php echo radiobutton_tag('revision', $revision->getRevision(), $rev2 == $revision->getRevision(),array("class"=>"revision")) ?></td>
      <?php endif ?>
      <td><?php echo link_to_wiki(null, $page->getName(), array('revision' => $revision->getRevision())) ?></td>
      <td><?php echo format_datetime($revision->getCreatedAt('U')) ?></td>
      <td><?php echo $revision->getUserName() ?></td>
     <!-- <td><em><?php //echo $revision->getComment() ?></em></td> -->
    </tr>
  <?php endforeach ?>
  </tbody>
 </table>
</div> 

<?php if (@$compare): ?>
  <p class="wiki-form-submit"><?php echo submit_tag(__('vedi i cambiamenti tra le versioni selezionate')) ?>
  |
  <?php echo link_to(__('annulla'), $sf_user->getAttribute('referer', '@homepage')) ?>
  </p> 
<?php endif ?>
</form>

<?php if (@$revision1 && @$revision2): ?>
  <?php include_partial('diff', array('page' => $page, 'revision1' => $revision1, 'revision2' => $revision2, 'diff' => $diff)) ?>
<?php endif ?>
