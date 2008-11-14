<?php use_helper('I18N') ?>

<h1 class="wiki-title"><?php echo __('Edit a page') ?></h1>

<?php if (!$canView): ?>
  <p class="wiki-warning"><?php echo __('You are not allowed to access this page.') ?></p>
<?php else: ?>

  <?php if (!$revision->isLatest()): ?>
    <p class="wiki-warning">
      <?php echo __('You are currently editing an old revision of this page. If you save these changes, all changed made since this revision will be lost !!') ?> 
      <?php echo link_to(__('Don\'t you want to edit the latest version of this page ?'), 'nahoWiki/edit?page=' . $page->getName()) ?>
    </p>
  <?php endif ?>

  <?php echo form_tag('nahoWiki/edit?' . $uriParams, 'name=edit_page id=edit_page class=wiki-form') ?>

    <?php if ($canEdit): ?>
      <?php if (!$sf_user->isAuthenticated()): ?>
        <p><?php echo __('You are not authenticated. Your IP address will be stored : %ip%.', array('%ip%' => '<strong>' . $userName . '</strong>')) ?></p>
      <?php else: ?>
        <p><?php echo __('You are authenticated. Your username will be stored : %username%.', array('%username%' => '<strong>' . $userName . '</strong>')) ?></p>
      <?php endif ?>
    <?php endif ?>

    <?php echo textarea_tag('content', $revision->getContent(true), 'size=80x20' . ($canEdit ? '' : ' readonly=yes')) ?>

    <?php if ($canEdit): ?>

      <p><?php echo label_for('comment', __('Comment')) ?> <?php echo input_tag('comment', $page->isNew() ? 'Creazione' : ($sf_request->getParameter('request-preview') ? $revision->getComment() : ''), 'size=80') ?></p>

      <p>
        <?php echo submit_tag(__('Save changes'), 'class=submit-button') ?> &nbsp;
      </p>

    <?php endif ?>

  </form>

  <?php if ($sf_request->getParameter('request-preview')): ?>
    <p class="wiki-warning"><?php echo __('This is a preview of how your text will look like. Remember: <strong>It is not saved yet</strong> !') ?></p>
    <?php include_partial('content', array('preview' => true, 'revision' => $revision, 'uriParams' => $uriParams)) ?>
  <?php endif ?>

<?php endif ?>

<script type="text/javascript">
//<![CDATA[

  wmd_options = {
		// format sent to the server.  Use "Markdown" to return the markdown source.
		output: "Markdown",

		// line wrapping length for lists, blockquotes, etc.
		lineLength: 60,

		// toolbar buttons.  Undo and redo get appended automatically.
		buttons: "bold italic heading hr | link blockquote  | ol ul ",

		// option to automatically add WMD to the first textarea found.  See apiExample.html for usage.
		autostart: true
	};

//]]>
</script>
<div class="wmd-preview" style="float:right"></div>
<script type="text/javascript" language="javascript" src="/js/wmd/wmd.js"></script>
