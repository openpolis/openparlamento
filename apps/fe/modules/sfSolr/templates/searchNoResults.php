<div class="row">
	<div class="ninecol">
		
		<div class="message" style="min-height: 100px; padding-top: 20px;">
	      <p>La tua ricerca del termine <strong><?php echo $query ?></strong> non ha prodotto alcun risultato</p>
	    </div>
		
	</div>
	<div class="threecol last"></div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  ricerca senza nessun risultato</em>
<?php end_slot() ?>
