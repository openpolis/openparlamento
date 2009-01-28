<?php echo use_helper('Tags') ?>
<em>argomenti:</em>
<?php foreach ($tags as $tag): ?>
  <div id="<?php echo $tag[0]?>" class="<?php echo get_classes_for_tag($tag[3], $teseo_tags, $user_tags, $my_tags) ?>">
    <?php if ($sf_user->hasCredential('administrator')): ?>
      <span class="remover" title="clicca qui per rimuovere questo tag">(X)</span>
    <?php endif ?>
    <span class="tag"><?php echo link_to(strtolower($tag[3]), '@tag?tag_name='.$tag[0])?></span>
  </div> &nbsp;
<?php endforeach ?>
