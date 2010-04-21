<?php if ($opp_politician_history_cache->getChiTipo() == 'P'): ?>
  <?php $parlamentare = OppCaricaPeer::retrieveByPK($opp_politician_history_cache->getChiId()) ?>
  <?php echo $parlamentare->getOppPolitico() ?> - 
  <?php echo link_to($parlamentare->getPoliticoId(), 
                     'http://' . sfConfig::get('sf_site_url', 'op_openpolis') . "/parlamentare/" . $parlamentare->getPoliticoId(),
                     true) ?>
  (<?php echo $parlamentare->getId() ?>)  
<?php endif ?>
