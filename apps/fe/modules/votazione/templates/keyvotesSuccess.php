<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'voti_chiave')) ?>


<div class="row">
	<div class="ninecol">
		
		 <?php include_partial('wikiKeyVotes') ?>  
	      <p>&nbsp;</p>
  	  	
  	  	<br/><br/>
	      <?php include_component('votazione','keyvotes', array('limit' => '0', 'pagina' => 'keyvotes', 'type' => 'key')) ?>
		
	</div>
	<div class="threecol last">
		
		<?php include_partial('votazioneRightColumn', array('query' => $query)) ?>  
	       <p align=center>
	      <?php //echo link_to(image_tag('/images/banner_grafico_230x80.png'),'/grafico_distanze/votes_16_C') ?>
	      </p>
	</div>
</div>


<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  voti chiave
<?php end_slot() ?>
