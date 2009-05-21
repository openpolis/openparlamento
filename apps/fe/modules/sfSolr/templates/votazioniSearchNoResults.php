<?php include_partial('votazione/tabs') ?>

<div id="content" class="tabbed float-container">

  <div id="main">
    <div class="W25_100 float-right">
      <?php 
        echo include_partial('sfSolr/votazioni_controls', 
                            array('query' => $query,
                                  'title' => 'nelle votazioni'));
      ?>

  	</div>

    <div class="W73_100 float-left">


      <div class="tabbed float-container" id="content">
      	<div id="main">
      	  <div class="W100_100 float-left" style="margin-bottom: 20px">

            <h2></h2>
            <p style="height: 100px; margin-top: 20px; margin-left: auto; margin-right: auto; font-size: 16px; font-weight: bold">La tua ricerca del termine <em><?php echo $query ?></em> nelle votazioni non ha prodotto alcun risultato</p>

          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  <?php echo link_to('Votazioni', '@votazioni') ?> / 
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>

