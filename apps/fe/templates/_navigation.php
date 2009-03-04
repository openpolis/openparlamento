<!-- motore di ricerca generico, contenuto in sfLucene/_controls.php -->
<?php include_partial('sfSolr/controls', 
                      array('query' => $this->getContext()->getRequest()->getParameter('query', '')));?>

<!-- menu di navigazione -->
<ul>
  <li>
    <?php if($this->getContext()->getModuleName() == 'atto' ||
             $this->getContext()->getModuleName() == 'sfLucene' && $this->getContext()->getActionName() == 'attiSearch'): ?>
      <?php echo link_to('Atti', 'atto/disegnoList', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Atti', 'atto/disegnoList') ?>
    <?php endif; ?>
  </li>
  <li>
    <?php if($this->getContext()->getModuleName() == 'votazione' ||
             $this->getContext()->getModuleName() == 'sfLucene' && $this->getContext()->getActionName() == 'votazioniSearch'): ?>
      <?php echo link_to('Votazioni', '@votazioni', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Votazioni', '@votazioni') ?>
    <?php endif; ?>
  </li>   
  <li>
    <?php if($this->getContext()->getModuleName() == 'parlamentare'): ?>
      <?php echo link_to('Parlamentari', '@parlamentari?ramo=camera', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Parlamentari', '@parlamentari?ramo=camera') ?>
    <?php endif; ?>
  </li>
  <li>
    <?php if($this->getContext()->getModuleName() == 'argomento'): ?>
      <?php echo link_to('Argomenti', '@argomenti', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Argomenti', '@argomenti') ?>
    <?php endif; ?>
  </li>
  <li><?php echo link_to('Comunit&agrave;', '#') ?></li>
  <li>
    <?php if($this->getContext()->getModuleName() == 'sfSimpleBlog'): ?>
      <?php echo link_to('Blog', '@blog_index', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Blog', '@blog_index') ?>
    <?php endif; ?>
  </li>
  <li></li>
</ul>