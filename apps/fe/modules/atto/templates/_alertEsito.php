<?php 
  $esito = OppEsitoSedutaPeer::retrieveByPK($result->propel_id);
  $atto = $esito->getOppAtto();
  $sede = $esito->getOppSede();
?>
  <?php echo $sede->getRamo() ?>  - esito <?php echo $esito->getId() ?> in <?php echo $sede->getDenominazione() ?>, riferito ad atto <?php echo $atto->getId() ?> (da modificare)

