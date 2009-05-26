<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>

  <?php
    $menu_items = array(
      'tag'=>'Tag',
      'teseott'=>'Categorie Teseo',
      'sfSimpleBlogPostAdmin' => 'Post del Blog',
      'sfSimpleBlogCommentAdmin' => 'Commenti del Blog',
      'sfEmendAdmin' => 'Commenti eMend',
      'atto' => 'Titoli aggiuntivi Atti',
      'votazione' => 'Titoli aggiuntivi Votazioni',
      'nuoviatti' => 'Nuovi atti',
      'sfSupraVariablesAdmin' => 'SupraVariables');
    $nitems = count($menu_items);
    $menu_sep = '|';
    $module_name = $sf_context->getModuleName(); 
  ?>
  <!-- menu principale -->
  <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
    <ul id="main_menu">
        <?php $cnt = 0; foreach($menu_items as $k=>$v): ?>
          <li <?php echo ($module_name==$k)?'class="selected"':'';?>><?php echo link_to($v, "/$k"); ?></li>
          <?php if ($cnt++ < $nitems-1) echo $menu_sep; ?>
        <?php endforeach; ?>

        <li>ciao, <?php echo $sf_user->getFirstname() ?>&nbsp;(<?php echo link_to('Logout', 'logout') ?>)</li>
    </ul>
  <?php endif; ?>

  <!-- contenuto -->
  <div id="main_content">
    <?php echo $sf_data->getRaw('sf_content') ?>
  </div>

</body>
</html>
