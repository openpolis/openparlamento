<div class="tabbed float-container" id="content">
	<div id="main">
	  <div class="W73_100 float-left message" style="min-height: 100px; padding-top: 20px;">
      <p>La tua ricerca del termine <strong><?php echo $query ?></strong> non ha prodotto alcun risultato</p>
    </div>
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  ricerca senza nessun risultato</em>
<?php end_slot() ?>
