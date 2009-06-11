<?php echo OppPremiumDemoPeer::getPercheAsString($opp_premium_demo->getPerche()) ?>

<?php if ($opp_premium_demo->getPercheAltroDesc() != ''): ?>
  (<?php echo $opp_premium_demo->getPercheAltroDesc() ?>)  
<?php endif ?>
