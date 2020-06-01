<?php include_partial('atto/tabs', array('current' => $type)) ?>

<div class="row">
	<div class="ninecol">
		
		<div class="message" style="min-height: 100px; padding-top: 20px;">
			<p>La tua ricerca del termine <strong><?php echo htmlspecialchars($query) ?></strong> non ha prodotto alcun risultato</p>
		</div>
		
		
	</div>
	<div class="threecol last">
		
		<?php 
	        echo include_partial('sfSolr/specialized_controls', 
	                            array('query' => $query,
	                                  'type'  => $type,
	                                  'title' => $title));
	      ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  <?php echo link_to('Atti', '@attiDisegni') ?> / 
  Ricerca per <i><?php echo htmlspecialchars($query) ?></i>
<?php end_slot() ?>
