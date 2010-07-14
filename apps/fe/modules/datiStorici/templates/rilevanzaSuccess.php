<?php include_partial('tabs', array('current' => 'rilevanza')) ?>

<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">
    <div>
      Visualizzaione dei dati storici sulla rilevanza degli atti.
    </div>
  </div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> / dati storici su rilevanza atti
<?php end_slot() ?>
