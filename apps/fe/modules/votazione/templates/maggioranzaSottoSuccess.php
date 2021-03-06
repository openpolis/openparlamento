<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'maggioranza_sotto')) ?>


<div class="row">
	<div class="twelvecol"><?php echo include_partial('secondLevelVotiMaggioranzaSotto', 
                               array('current' => 'lista')); ?></div>
</div>
<div class="row">
	<div class="ninecol">
		
		<p style="padding:10px 0 5px 0; font-size:16px;">
	         In questa legislatura la maggioranza parlamentare che sostiene il Governo &egrave; stata battuta in <?php echo $pager->getNbResults() ?> votazioni elettroniche d'aula di Camera e Senato.
	        <span style="background-color:yellow;">Non sono considerate le votazioni non elettroniche e quelle con voto segreto.</span>
	        <?php include_partial('wikiMaggioranzaSotto') ?>  
	        </p>		

	      <?php include_partial('filter',
	                            array('tags_categories' => $all_tags_categories,
	                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
	                                  'selected_type' => array_key_exists('type', $filters)?$filters['type']:0,                                
	                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
	                                  'selected_ramo' => array_key_exists('ramo', $filters)?$filters['ramo']:0,
	                                  'selected_esito' => array_key_exists('esito', $filters)?$filters['esito']:0)) ?>



	      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

	      <?php include_partial('maggioranzaSotto', array('pager' => $pager)) ?>
		
	</div>
	<div class="threecol last">
		
		<?php include_partial('votazioneRightColumn', array('query' => $query)) ?>  
	       <p align=center>
	         <strong>
	           vedi anche:</strong><br/>
	         <?php echo link_to('I <strong>deputati</strong> che fanno cadere la maggioranza', '@parlamentariSotto?ramo=camera') ?>
	         <br/>
	         <?php echo link_to('I <strong>senatori</strong> che fanno cadere la maggioranza', '@parlamentariSotto?ramo=senato') ?>

	      <?php //echo link_to(image_tag('/images/banner_grafico_230x80.png'),'/grafico_distanze/votes_16_C') ?>
	      </p>
		
	</div>
</div>


<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  voti con maggioranza battuta
<?php end_slot() ?>