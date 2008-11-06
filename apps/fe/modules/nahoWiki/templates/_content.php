<?php use_helper('I18N') ?>

<?php if (!isset($display_pagename)) $display_pagename = sfConfig::get('app_nahoWikiPlugin_include_pagename', true) ?>
<?php if (!isset($display_toc)) $display_toc = sfConfig::get('app_nahoWikiPlugin_include_toc', true) ?>

<?php slot('wiki_page_name') ?>
  <h1 class="wiki-title">
    <?php if (@$preview): ?><em><?php echo __('Preview') ?></em> : <?php endif ?>
    <?php echo $revision->getPage()->getName() ?>
  </h1>
<?php end_slot() ?>

<div class="wiki-page<?php if (@$preview) echo ' wiki-preview' ?>">
  <?php if ($display_pagename) include_slot('wiki_page_name') ?>
  <?php include_slot('wiki_page_header') ?>
  <?php if (@$no_article): ?>
    <p class="wiki-warning">
      <?php echo __('There is no article here yet.') ?>
    </p>
  <?php else: ?>
    <?php $content = $revision->getXHTMLContent() ?>
    <?php if ($display_toc): ?>
      <?php $toc = nahoWikiContentPeer::getTOC($content) ?>
      <div class="wiki-toc-container">
        <a class="wiki-toc-header" href="#" onclick="var n=document.getElementById('wiki-toc');n.style.display=n.style.display=='none'?'block':'none';return false"><?php echo __('Table of contents') ?></a>
        <div id="wiki-toc"><?php include_partial('toc', array('toc' => $toc)) ?></div>
      </div>
    <?php endif ?>
    <?php echo $content ?>
  <?php endif ?>
  <?php include_slot('wiki_page_footer') ?>
</div>

