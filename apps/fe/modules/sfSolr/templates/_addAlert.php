<?php if ($sf_flash->has('notice')): ?>
  <div class="flash-messages" style="background-color: #afa">
    <?php echo $sf_flash->get('notice') ?>
  </div>
<?php endif; ?>

<?php if ($sf_user->isAuthenticated() && 
          ($sf_user->hasCredential('amministratore') || $sf_user->hasCredential('adhoc')) &&
          !OppAlertUserPeer::hasAlert($query, OppUserPeer::retrieveByPK($sf_user->getId()), $type_filters)): ?>
  <h4 style="margin-left: 0.5em">
    <?php echo link_to("avvisami quando questa espressione viene usata alla Camera o al Senato" . ($type_filters!=''?", con questi filtri: $type_filters_label":""), 'monitoring/addAlert?term='.str_replace("/", "|", $query)."&type_filters=$type_filters") ?>
  </h4>        
<?php endif ?>
