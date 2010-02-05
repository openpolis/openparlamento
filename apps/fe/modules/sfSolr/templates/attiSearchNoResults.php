<?php include_partial('atto/tabs', array('current' => $type)) ?>

<div id="content" class="tabbed float-container">

  <div id="main">

    <div class="W25_100 float-right">
      <?php 
        echo include_partial('sfSolr/specialized_controls', 
                            array('query' => $query,
                                  'type'  => $type,
                                  'title' => $title));
      ?>

  	</div>

    <div class="W73_100 float-left message" style="min-height: 100px; padding-top: 20px;">
      <p>La tua ricerca del termine <strong><?php echo $query ?></strong> non ha prodotto alcun risultato</p>
    </div>

  </div>

</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  <?php echo link_to('Atti', '@attiDisegni') ?> / 
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>