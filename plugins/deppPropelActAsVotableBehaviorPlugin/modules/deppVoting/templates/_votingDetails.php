<?php sfLoader::loadHelpers('I18N') ?>
<?php if (isset($object)): ?>
  <div id="total-votings"><span class="label"><?php echo __('Total votings') ?></span>: <?php echo $total_votings ?></div>
  <ul id="voting-details">
  <?php foreach ($voting_details as $voting => $details): ?>
    <?php if ($voting==0 && !$object->allowsNeutralPosition() ) continue; ?>
    <li>
      <div class="value"><?php echo sprintf(__('%d'), $voting) ?>: </div>
      <?php if ($details['count'] > 0): ?>
        <div class="votes"><?php echo $details['count'] ?></div>
        <div class="percentage-bar" style="width:<?php echo $details['percent'] * 2 ?>px">&nbsp;</div>
        <div class="percentage-value">(<?php echo $details['percent'] ?>%)</div>        
      <?php else: ?>
        <div class="votes">nessun voto</div>        
      <?php endif ?> 
    </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<div id="closing"></div>