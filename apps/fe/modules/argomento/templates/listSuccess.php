<?php foreach($argomenti as $argomento): ?>
  <div><?php echo link_to($argomento->getDenominazione(),'#') ?></div>
<?php endforeach; ?>