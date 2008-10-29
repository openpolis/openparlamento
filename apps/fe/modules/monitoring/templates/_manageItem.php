<?php echo use_helper('Javascript') ?>


<?php if ($sf_user->isAuthenticated()): ?>
  <?php if (!isset($isAjaxResponse) || $isAjaxResponse == true): ?>
    <div id="item_manager"> 
  <?php endif ?> 
    <?php if ($is_monitoring): ?>
      Il monitoraggio &egrave; attivo. 
      <?php if (isset($remaining_items)): ?>
        Hai a disposizione ancora <?php echo $remaining_items ?> token.         
      <?php endif ?>
      <?php echo link_to_remote('Smetti di monitorare', 
                                array( 'update' => 'item_manager', 
                                       'url' => 'monitoring/ajaxRemoveItemFromMyMonitoredItems?item_model='.$item_model.'&item_pk='.$item_pk)) ?>
    <?php else: ?>
      <?php if (isset($remaining_items)): ?>
        Puoi aggiungere altri <?php echo $remaining_items ?> token. 
      <?php endif ?>
      <?php echo link_to_remote('Monitora', 
                                array( 'update' => 'item_manager', 
                                       'url' => 'monitoring/ajaxAddItemToMyMonitoredItems?item_model='.$item_model.'&item_pk='.$item_pk)) ?>
    <?php endif ?>
  <?php if (!isset($isAjaxResponse) || $isAjaxResponse == true): ?>
    </div> 
  <?php endif ?> 
<?php endif ?>  
