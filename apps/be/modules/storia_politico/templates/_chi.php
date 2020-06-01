<?php if ($opp_politician_history_cache->getChiTipo() == 'P' || 
          $opp_politician_history_cache->getChiTipo() == 'N'): ?>
  <?php $parlamentare = OppCaricaPeer::retrieveByPK($opp_politician_history_cache->getChiId()) ?>
  <a href="/xml/indici/politici/<?php echo $parlamentare->getId() ?>.xml" target="_blank">
    <?php echo $parlamentare->getOppPolitico() ?>
  </a>
  -
  <?php echo link_to($parlamentare->getPoliticoId(), 
                     'https://' . sfConfig::get('sf_site_url', 'op_openpolis') . "/parlamentare/" . $parlamentare->getPoliticoId(),
                     true) ?>
  (<?php echo $parlamentare->getId() ?>)  
<?php endif ?>
