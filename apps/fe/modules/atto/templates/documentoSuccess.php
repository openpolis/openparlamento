<h1><?php echo $documento->getTitolo() ?></h1>
<br /><br />

<?php if($documento->getUrlTesto()): ?>
  <div><b><?php echo link_to('fonte', $documento->getUrlTesto()) ?></b></div>
  <br />
<?php endif; ?>

<?php if($documento->getUrlPdf()): ?>
  <div><b><?php echo link_to('scarica il documento in PDF', $documento->getUrlPdf()) ?></b></div>
  <br />
<?php endif; ?>

Atto associato: <?php echo link_to(Text::denominazioneAtto($documento->getOppAtto(), 'list'), 'atto/index?id='.$documento->getOppAtto()->getId()) ?>
<br /><br />

<?php if($documenti_correlati): ?>
  Altri documenti riferiti allo stesso atto<br />
  <?php foreach($documenti_correlati as $documento_correlato): ?>
    <?php echo link_to($documento_correlato->getTitolo(), 'atto/documento?id='.$documento_correlato->getId() ) ?><br />
  <?php endforeach; ?>
<br /><br />
<?php endif; ?>

<?php if($documento->getTesto()): ?>
  <?php echo $documento->getTesto() ?>
<?php else: ?>
  testo non disponibile
<?php endif; ?>  
  