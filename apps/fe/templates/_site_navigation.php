<!-- menu di navigazione -->
<ul id="menu">
  <li>
    <?php if($this->getContext()->getModuleName() == 'atto' ||
             $this->getContext()->getModuleName() == 'sfLucene' && $this->getContext()->getActionName() == 'attiSearch'): ?>
      <?php echo link_to('Atti', '@attiEvidenza', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Atti', '@attiEvidenza') ?>
    <?php endif; ?>
  </li>
  <li>
    <?php if($this->getContext()->getModuleName() == 'votazione' ||
             $this->getContext()->getModuleName() == 'sfLucene' && $this->getContext()->getActionName() == 'votazioniSearch'): ?>
      <?php echo link_to('Voti', '@votichiave', array('class' => 'current')) ?>
    <?php else: ?>
      <?php echo link_to('Voti', '@votichiave') ?>
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
  <li><span style="font-size:10px;"><a href="http://parlamento17.openpolis.it/">Precedente legislatura 2013-2018</a></span></li>
</ul>
