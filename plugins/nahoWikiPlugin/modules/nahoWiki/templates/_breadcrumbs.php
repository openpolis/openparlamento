<?php use_helper('nahoWiki') ?>

<div class="wiki-breadcrumbs">
  <?php $first = true; foreach ($breadcrumbs as $breadcrumb): ?>
    <?php if (!$first): ?><span class="wiki-breadcrumbs-separator"><?php echo $breadcrumbs_separator ?></span><?php endif ?>
		<?php echo link_to_wiki(null, $breadcrumb) ?>
  <?php $first = false; endforeach ?>
</div>