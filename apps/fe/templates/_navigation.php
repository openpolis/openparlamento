<ul>
  <li>
    <?php if($this->getContext()->getActionName() == 'disegnoList' || $this->getContext()->getActionName() == 'decretoList' || $this->getContext()->getActionName() == 'decretoLegislativoList'): ?>
      <span class="current">Disegni di legge e decreti</span>
    <?php else: ?>
      <?php echo link_to('Disegni di legge e decreti', 'atto/disegnoList') ?>
    <?php endif; ?>
  </li>
  <li>
    <?php if($this->getContext()->getActionName() == 'attoNonLegislativoList'): ?>
      <span class="current">Atti non legislativi</span>
    <?php else: ?>
      <?php echo link_to('Atti non legislativi', 'atto/attoNonLegislativoList') ?>
    <?php endif; ?>
  </li>
  <li>
    <?php if($this->getContext()->getModuleName() == 'votazione'): ?>
      <span class="current">Votazioni</span>
    <?php else: ?>
      <?php echo link_to('Votazioni', '@votazioni') ?>
    <?php endif; ?>
  </li>   
  <li>
    <?php if($this->getContext()->getModuleName() == 'parlamentare'): ?>
      <span class="current">Parlamentari</span>
    <?php else: ?>
      <?php echo link_to('Parlamentari', '@parlamentari?legislatura=16&carica=Deputato') ?>
    <?php endif; ?>
  </li>
  <li><?php echo link_to('Argomenti', '@argomenti') ?></li>
  <li><?php echo link_to('Comunit&agrave;', '#') ?></li>
  <li><?php echo link_to('Blog', '#') ?></li>

  <?php if ($sf_user->isAuthenticated()): ?>
    <li><?php echo link_to('Monitoring', 'monitoring') ?></li>
    <li>ciao, <?php echo $sf_user->getFirstname() ?>&nbsp;(<?php echo link_to('Logout', 'logout') ?>)</li>
  <?php else: ?>
    <?php if ($this->getContext()->getModuleName() != 'sfGuardAuth'): ?>
      <li><?php echo link_to('Login', 'login') ?></li>      
    <?php endif ?>
  <?php endif; ?>
</ul>