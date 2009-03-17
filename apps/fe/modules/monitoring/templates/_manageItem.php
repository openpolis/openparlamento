<?php echo use_helper('I18N') ?>

<?php if ($sf_user->isAuthenticated()): ?>

  <div id="item_manager"> 
  
    <?php if ($is_monitoring): ?>
      <h6 class="start-monitoring">
        <?php echo link_to('interrompi il monitoraggio di questo contenuto' . 
                             (isset($remaining_items)?' (ancora '.$remaining_items.' token)':''),
                           'monitoring/removeItemFromMyMonitoredItems?item_model='.$item_model.'&item_pk='.$item_pk,
                           array('post' => true)) ?>
      </h6>
    <?php else: ?>
      <h6 class="stop-monitoring">
        <?php echo link_to('avvia il monitoraggio per questo contenuto' . 
                            (isset($remaining_items)?' (ancora '.$remaining_items.' token)':''),
                           'monitoring/addItemToMyMonitoredItems?item_model='.$item_model.'&item_pk='.$item_pk,
                           array('post' => true)) ?>
      </h6>
    <?php endif ?>

    <p><?php echo format_number_choice('[0]<strong>Nessuno</strong> monitora|[1]<strong>Un</strong> utente monitora|(1,+Inf]<strong>%1%</strong> utenti monitorano', array('%1%' => $nMonitoringUsers), $nMonitoringUsers) ?> questo <?php echo $item_type ?></p>
    
  </div> 

<?php else: ?>
  <h6 class="start-monitoring">
    <?php echo link_to('effettua il login per monitorare', '/login') ?>
  </h6>
<?php endif ?>  

