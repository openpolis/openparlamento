<?php sfLoader::loadHelpers('I18N') ?>
<?php if (isset($object)): ?>
  <div id="total-bookmarkings"><span class="label"><?php echo __('Total bookmarkings') ?></span>: <?php echo $total_bookmarkings ?></div>
  <ul id="bookmarking-details">
  <?php foreach ($bookmarking_details as $bookmarking => $details): ?>
    <?php if ($bookmarking==0 && !$object->allowsNeutralPosition() ) continue; ?>
    <li>
      <div class="value"><?php echo sprintf(__('%d'), $bookmarking) ?>: </div>
      <?php if ($details['count'] > 0): ?>
        <div class="bookmarks"><?php echo $details['count'] ?></div>
        <div class="percentage-bar" style="width:<?php echo $details['percent'] * 2 ?>px">&nbsp;</div>
        <div class="percentage-value">(<?php echo $details['percent'] ?>%)</div>        
      <?php else: ?>
        <div class="bookmarks">nessun bookmark</div>        
      <?php endif ?> 
    </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<div id="closing"></div>