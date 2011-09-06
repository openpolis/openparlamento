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
      <?php echo link_to('Voti', '/votazioni/keyvotes', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Voti', '/votazioni/keyvotes') ?>
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
  <li>
    <?php if($this->getContext()->getModuleName() == 'community'): ?>
      <?php echo link_to('Comunit&agrave;', 'community', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Comunit&agrave;', 'community') ?>
    <?php endif; ?>
  </li>
  <li>
    <a href="http://blog.openpolis.it/">Il blog di openpolis</a>
  </li>
  <li></li>
</ul>