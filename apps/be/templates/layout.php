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
      'deppCommentingAdmin' => 'Commenti',
      'sfSimpleBlogPostAdmin' => 'Post del Blog',
      'sfSimpleBlogCommentAdmin' => 'Commenti del Blog',
      'sfEmendAdmin' => 'Commenti eMend',
      'sfEmendLogAdmin' => 'Log eMend',
      'atto' => 'Titoli aggiuntivi',
      'nuoviatti' => 'Nuovi atti',
      'documento' => 'Documenti allegati',
      'premiumdemo' => 'Utenti premium',
      'sfSupraVariablesAdmin' => 'SupraVariables');
    $nitems = count($menu_items);
    $menu_sep = '|';
    $module_name = $sf_context->getModuleName(); 
  ?>
  <!-- menu principale -->
  <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
    <ul id="main_menu">
        <?php $cnt = 0; foreach($menu_items as $k=>$v): ?>
          <?php if ($module_name==$k || 
                    in_array($module_name, array('atto', 'votazione', 'emendamento')) && $k=='atto' ): ?>
            <li class="selected"><?php echo link_to($v, "/$k"); ?></li>
          <?php else: ?>
            <li><?php echo link_to($v, "/$k"); ?></li>
          <?php endif ?>
          <?php if ($cnt++ < $nitems-1) echo $menu_sep; ?>
        <?php endforeach; ?>

        <li>ciao, <?php echo $sf_user->getFirstname() ?>&nbsp;(<?php echo link_to('Logout', 'logout') ?>)</li>
    </ul>
  <?php endif; ?>

  <?php if ( in_array($module_name, array('atto', 'votazione', 'emendamento')) ): ?>
    <div style="clear:both;">
    <ul id="sub_menu">
      <li <?php echo ($module_name == 'atto')?'class="selected"':'';?>><?php echo link_to('Atti', "/atto"); ?></li> |
      <li <?php echo ($module_name == 'votazione')?'class="selected"':'';?>><?php echo link_to('Votazioni', "/votazione"); ?></li> |
      <li <?php echo ($module_name=='emendamento')?'class="selected"':'';?>><?php echo link_to('Emendamenti', "/emendamento"); ?></li> |
    </ul>
    </div>
  <?php endif; ?>


  <!-- contenuto -->
  <div id="main_content">
    <?php echo $sf_data->getRaw('sf_content') ?>
  </div>

</body>
</html>
