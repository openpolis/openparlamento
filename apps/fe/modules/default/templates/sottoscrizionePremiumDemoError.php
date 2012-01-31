<?php use_helper('Validation') ?>

<div class="row">
	<div class="twelvecol">
		
		<h3>Si è verificato un errore!</h3>

	    <p><?php echo $error ?></p>


	    <div>
	      Torna
	      <?php echo link_to('alla pagina che stavi visitando', $sf_user->getAttribute('page_before_buy', '@homepage')) ?>.
	    </div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Sottoscrizione dimostrativa Premium
<?php end_slot() ?>

