<?php if ($opp_politician_history_cache->getChiTipo() == 'P'): ?>
  <?php $parlamentare = OppCaricaPeer::retrieveByPK($opp_politician_history_cache->getChiId()) ?>
  <?php echo $parlamentare->getOppPolitico() ?>  
<?php endif ?>
