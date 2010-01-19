<?php 
  $esito = OppEsitoSedutaPeer::retrieveByPK($result->propel_id);
  if ($esito instanceof OppEsitoSedutaPeer)
  {
    $atto = $esito->getOppAtto();
    $sede = $esito->getOppSede();    
  }
?>

<?php if ($esito instanceof OppEsitoSedutaPeer): ?>
  <?php
    $atto = $esito->getOppAtto();
    $sede = $esito->getOppSede();      
  ?>
  <?php echo $sede->getRamo() ?>  - esito <?php echo $esito->getId() ?> in <?php echo $sede->getDenominazione() ?>, riferito ad atto <?php echo $atto->getId() ?> (da modificare)
<?php else: ?>
  Errore! Il risultato <?php echo $result->propel_id ?> si riferisce a un oggetto non più presente nel DB
<?php endif ?>

