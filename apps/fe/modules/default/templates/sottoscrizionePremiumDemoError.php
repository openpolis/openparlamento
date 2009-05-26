<?php use_helper('Validation') ?>

<div id="content" class="float-container" style="margin-top: 5px">
  <div id="main" style="padding: 2.5em 1em">
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

