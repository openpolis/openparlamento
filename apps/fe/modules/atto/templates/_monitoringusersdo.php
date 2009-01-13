<?php if (count($monitored_models_pks)): ?>
  <div class="pink-vanity">	
  	<h5 class="subsection">Gli utenti che monitorano questo DDL stanno monitorando anche...</h5>

    <?php foreach ($monitored_models_pks as $model): ?>
    	<h5 class="subsection-spec">...
    	  <?php switch ($model){
    	         case 'OppPolitico':
     	           echo 'i politici';
     	           break;
    	         case 'OppAtto':
    	           echo 'gli atti';
    	           break;
    	         case 'Tag':
    	           echo 'gli argomenti';
    	           break;
    	  }?>
    	:</h5>

      <?php $monitored_items = MonitoringPeer::getItemsMonitoredByUsers($monitorers_pks, $model); ?>
      <?php uasort($monitored_items, 'MonitoringPeer::compareItemsByMonitoringUsers'); ?>
      <?php $items = array_slice($monitored_items, 0, 10); ?>
    	<div class="topics float-container">
        <?php foreach ($items as $item): ?>
          <?php echo include_component('atto', 'itemshortinline', array('item' => $item)); ?>
        <?php endforeach ?>
    	</div>		    

    <?php endforeach ?>

  </div>  
<?php endif ?>
