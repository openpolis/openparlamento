<?php echo use_helper('I18N') ?>

<?php if ($sf_user->isAuthenticated()): ?>

  <div id="item_manager"> 
  
    <?php if ($is_monitoring): ?>
      <h6 class="start-monitoring">
        <?php echo link_to('interrompi il monitoraggio di questo contenuto',
                           'monitoring/removeItemFromMyMonitoredItems?item_model='.$item_model.'&item_pk='.$item_pk,
                           array('post' => true)) ?>
      </h6>
    <?php else: ?>
      <h6 class="stop-monitoring">
        <?php echo link_to('avvia il monitoraggio per questo contenuto',
                           'monitoring/addItemToMyMonitoredItems?item_model='.$item_model.'&item_pk='.$item_pk,
                           array('post' => true)) ?>
      </h6>
    <?php endif ?>

  </div> 

<?php else: ?>
  <h6 class="start-monitoring">
    <?php echo link_to('effettua il login per monitorare', '/login') ?>
  </h6>
<?php endif ?>  


<?php echo include_partial('monitoring/monitoringDetails', 
                           array('nMonitoringUsers' => $nMonitoringUsers, 
                                 'item_type' => $item_type)); ?>
