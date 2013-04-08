<?php include_partial('tabs',array('ramo'=>2,'gruppi'=>true)) ?>

<div class="row">
	<div class="twelvecol">
		
		<div>
			<?php //include_partial('wikiGruppi') ?>  
			<?php echo include_component('parlamentare','gruppiParlamentari',array('ramo' => 2, 'leg'=> 17)) ?>
		</div>
		
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
    gruppi del senato
<?php end_slot() ?>