<?php echo OppPremiumDemoPeer::getAttivitaAsString($opp_premium_demo->getAttivita()) ?>

<?php if ($opp_premium_demo->getAttivitaAutDesc() != ''): ?>
  (<?php echo $opp_premium_demo->getAttivitaAutDesc() ?>)  
<?php endif ?>
<?php if ($opp_premium_demo->getAttivitaDipDesc() != ''): ?>
  (<?php echo $opp_premium_demo->getAttivitaDipDesc() ?>)  
<?php endif ?>
<?php if ($opp_premium_demo->getAttivitaAmmDesc() != ''): ?>
  (<?php echo $opp_premium_demo->getAttivitaAmmDesc() ?>)  
<?php endif ?>
