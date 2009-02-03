<?php echo use_helper('Javascript', 'I18N') ?>

<?php if ($sf_user->isAuthenticated()): ?>

  <?php if (!isset($isAjaxResponse) || $isAjaxResponse != true): ?>
    <div id="item_manager"> 
  <?php endif ?> 
  
    <?php if ($is_monitoring): ?>
      <h6 class="start-monitoring">
        <?php echo link_to_remote('interrompi il monitoraggio di questo contenuto' . 
                                  (isset($remaining_items)?' (ancora '.$remaining_items.' token)':''),
                                  array('update' => 'item_manager',
                                        'url' => 'monitoring/ajaxRemoveItemFromMyMonitoredItems?item_model='.$item_model.'&item_pk='.$item_pk)) ?>
      </h6>
    <?php else: ?>
      <h6 class="stop-monitoring">
        <?php echo link_to_remote('avvia il monitoraggio per questo contenuto' . 
                                  (isset($remaining_items)?' (ancora '.$remaining_items.' token)':''),
                                  array('update' => 'item_manager',
                                        'url' => 'monitoring/ajaxAddItemToMyMonitoredItems?item_model='.$item_model.'&item_pk='.$item_pk)) ?>
      </h6>
    <?php endif ?>

    <p><?php echo format_number_choice('[0]<strong>Nessuno</strong> monitora|[1]<strong>Un</strong> utente monitora|(1,+Inf]<strong>%1%</strong> utenti monitorano', array('%1%' => $nMonitoringUsers), $nMonitoringUsers) ?> questo <?php echo $item_type ?></p>
    
  <?php if (!isset($isAjaxResponse) || $isAjaxResponse != true): ?>
    </div> 
  <?php endif ?> 

<?php else: ?>
  <h6 class="start-monitoring">
    <?php echo link_to('effettua il login per monitorare', '/login') ?>
  </h6>
<?php endif ?>  

