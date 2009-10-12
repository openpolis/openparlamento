<?php echo use_helper('DeppNews'); ?>

<?php 
  $df = new sfDateFormat('it_IT'); 
  $sf_site_url = sfConfig::get('sf_site_url', 'openparlamento');
?>


IMPORTANTE!
===========

Il rinnovo del sito della Camera dei Deputati comporterà, da lun. 12 ottobre, la sospensione
per qualche tempo di parte dei nostri servizi. Ce ne scusiamo e vi promettiamo che avrete al più
presto un monitoraggio sempre migliore e competo. (per saperne di più)
http://parlamento.openpolis.it/blog/2009/10/08/la-camera-rinnova-il-sito-e-openparlamento-per-un-p-andra-a-scartamento-ridotto

buona partecipazione!
openpolis/openparlamento



Le ultime notizie
=================

<?php foreach ($grouped_news as $date_ts => $news): ?>
  <?php foreach ($news as $i => $n): ?>
    <?php if( $i == 0 ): ?>
      <?php if ($date_ts > 0): ?>
        <?php $date_string = $df->format($date_ts, 'dd') ." ". $df->format($date_ts, 'MMM') ." ". $df->format($date_ts, 'yyyy'); ?>
<?php echo $date_string ?>
<?php echo str_repeat('-', strlen($date_string))?>
      <?php else: ?>
NO data
-------
      <?php endif ?>
    <?php endif ?>
<?php echo html_entity_decode(strip_tags(news_text($n)), ENT_COMPAT, 'UTF-8'); ?>
:::

  <?php endforeach; ?>
  
  
<?php endforeach; ?>

Saluti,
il team Openpolis
