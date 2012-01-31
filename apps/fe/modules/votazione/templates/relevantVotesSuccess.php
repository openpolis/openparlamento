<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'voti_rilevanti')) ?>

<div class="row">
	<div class="ninecol">
		
		<?php include_partial('wikiRelevantVotes') ?>  
	      <p>&nbsp;</p>                 
	      <?php include_component('votazione', 'keyvotes', array('limit' => '0', 'type' => 'relevant', 'pagina' => 'keyvotes')) ?>
		
	</div>
	<div class="threecol last">
		
		<?php include_partial('votazioneRightColumn', array('query' => $query)) ?>  
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  voti chiave
<?php end_slot() ?>
