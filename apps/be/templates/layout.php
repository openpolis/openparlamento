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
      '@blog_posts' => 'Post del Blog',
      '@blog_comments' => 'Commenti del Blog');
    $nitems = count($menu_items);
    $menu_sep = '|';
    $module_name = $sf_context->getModuleName(); 
  ?>
  <!-- menu principale -->
  <ul id="main_menu">
    <?php $cnt = 0; foreach($menu_items as $k=>$v): ?>
      <li <?php echo ($module_name==$k)?'class="selected"':'';?>><?php echo link_to($v, "/$k"); ?></li>
      <?php if ($cnt++ < $nitems-1) echo $menu_sep; ?>
    <?php endforeach; ?>

    <?php if ($sf_user->isAuthenticated()): ?>
      <li>ciao, <?php echo $sf_user->getFirstname() ?>&nbsp;(<?php echo link_to('Logout', 'logout') ?>)</li>
    <?php else: ?>
      <?php if ($this->getContext()->getModuleName() != 'sfGuardAuth'): ?>
        <li><?php echo link_to('Login', 'login') ?></li>      
      <?php endif ?>
    <?php endif; ?>
  </ul>

  <!-- contenuto -->
  <div id="main_content">
    <?php echo $sf_data->getRaw('sf_content') ?>
  </div>

</body>
</html>
