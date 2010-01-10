<?php if ($item_type == 'emendamento'): ?>
  <?php $attoPortante = $item->getAttoPortante(); ?>
  <?php slot('breadcrumbs') ?>
      <?php echo link_to("home", "@homepage") ?> /
      <?php include_partial('atto/breadcrumbsAtti', array('atto' => $attoPortante)) ?> /
      <?php echo link_to(Text::denominazioneAttoShort($attoPortante), '@singolo_atto?id=' . $attoPortante->getId() ) ?> /
      <?php echo link_to('Emendamenti', '@emendamenti_atto?id='.$attoPortante->getId()) ?> /
      <?php echo link_to('Emendamento ' . $item->getTitolo(), '@singolo_emendamento?id='.$item->getId()) ?> /
      Descrizione Wiki
  <?php end_slot() ?>
<?php else: ?>
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
<?php endif ?>

