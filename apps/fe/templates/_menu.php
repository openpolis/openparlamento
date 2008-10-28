<ul class="menu">
  <li><?php echo link_to('Elenco DDL/ATTI', 'atto/ddlList') ?></li>
  <li><?php echo link_to('Votazioni', '@votazioni') ?></li>
  <li><?php echo link_to('Parlamentari', '@parlamentari?legislatura=16&carica=Deputato') ?></li>
  <li><?php echo link_to('Argomenti', '@argomenti') ?></li>
  <li><?php echo link_to('Comunit&agrave;', '#') ?></li>

  <?php if ($sf_user->isAuthenticated()): ?>
    <li><?php echo link_to('Monitoring', 'monitoring') ?></li>
    <li>ciao, <?php echo $sf_user->getFirstname() ?>&nbsp;(<?php echo link_to('Logout', 'logout') ?>)</li>
  <?php else: ?>
    <?php if ($this->getContext()->getModuleName() != 'sfGuardAuth'): ?>
      <li><?php echo link_to('Login', 'login') ?></li>      
    <?php endif ?>
  <?php endif; ?>
</ul>

