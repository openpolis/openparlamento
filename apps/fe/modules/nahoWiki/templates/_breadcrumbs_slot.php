<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  <?php if ($item_type == 'atto'): ?>
    <?php echo link_to('Atti', '@attiDisegni') ?> / 
  <?php else: ?>
    <?php echo link_to('Votazioni', '@votazioni') ?> / 
  <?php endif ?>
  <?php echo link_to($item_name, $link_back) ?> /
  Descrizione wiki
<?php end_slot() ?>
