<?php if (count($monitored_models_pks)): ?>
  <div class="pink-vanity">	
  	<p class="open-next-div"><a class="action" href="#">questi utenti monitorano anche...</a></p>		

  	<div style="display: none;" class="monitoring-also">
  		<hr class="dotted"/>			

      <?php foreach ($monitored_models_pks as $model): ?>
        <?php if ($model == 'Tag') continue; ?>

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

    	<p class="open-prev-div" style="text-align: right"><a class="action" href="#">chiudi</a></p>		

  	</div>
  </div>


  <script>
  jQuery.noConflict();
  (function($) {
    $(document).ready(function(){
      $('.open-next-div a').click(
      	function(){
      	  $(this).parent('p').next('div').toggle();
      	});
      	
      $('.open-prev-div a').click(
        function(){
           $(this).parent('p').parent('div').toggle();
        });
    });
  })(jQuery);
  </script>
  
<?php endif ?>
