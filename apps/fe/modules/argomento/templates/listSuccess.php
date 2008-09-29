<?php foreach($argomenti as $argomento): ?>
  <div><?php echo link_to($argomento->getDenominazione(),'@argomento?id='.$argomento->getId()) ?></div>
<?php endforeach; ?>