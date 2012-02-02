<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'evidenza')) ?>

<div class="row">
	<div class="twelvecol">
		
		<?php include_partial('evidenzaWiki') ?>      		
        <p>&nbsp;</p>                 
        <?php include_component('atto', 'evidenza', array('limit' => '0')) ?>

	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  atti in evidenza
<?php end_slot() ?>
