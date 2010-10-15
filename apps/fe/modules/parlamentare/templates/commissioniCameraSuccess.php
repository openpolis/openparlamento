<div id="content" class="tabbed float-container">
  <div id="main">
  <?php foreach ($comms as $comm) : ?>
    <?php echo include_component('parlamentare','commissioniPermanenti',array('sede_id' => $comm->getId(),'leg' => 16)) ?>
  <?php endforeach; ?>  
  </div>
</div>  