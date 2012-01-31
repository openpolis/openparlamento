<?php include_partial('tabs',array('ramo'=>1,'gruppi'=>true)) ?>

<div class="row">
	<div class="twelvecol">
		
		<div>
			<?php //include_partial('wikiGruppi') ?>      
		<?php echo include_component('parlamentare','gruppiParlamentari',array('ramo' => 1, 'leg'=> 16)) ?>
		</div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
    gruppi della camera
<?php end_slot() ?>