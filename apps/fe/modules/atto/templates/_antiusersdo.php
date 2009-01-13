<?php if (count($pro_acts)>0 || count($anti_acts)>0): ?>  
<div class="pink-vanity">	

	<h5 class="subsection">Gli utenti contrari a questo atto...</h5>

  <?php if (count($anti_acts)>0): ?>
  	<h5 class="subsection-spec">...sono contrari anche a:</h5>
  	<div class="topics float-container">
      <?php foreach ($anti_acts as $item): ?>
        <?php echo include_component('atto', 'itemshortinline', array('item' => $item)); ?>
      <?php endforeach ?>
  	</div>		        
  <?php endif ?>

  <?php if (count($pro_acts)>0): ?>
  	<h5 class="subsection-spec">...sono favorevoli a:</h5>
  	<div class="topics float-container">
      <?php foreach ($pro_acts as $item): ?>
        <?php echo include_component('atto', 'itemshortinline', array('item' => $item)); ?>
      <?php endforeach ?>
  	</div>		        
  <?php endif ?>

</div>
<?php endif ?>
