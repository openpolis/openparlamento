<?php use_helper('sfSolr', 'I18N', 'PagerNavigation') ?>

<?php include_partial('votazione/tabs') ?>

<div id="content" class="tabbed float-container">

  <div id="main">
    <div class="W25_100 float-right">
      <?php 
        echo include_partial('sfSolr/votazioni_controls', 
                            array('query' => $query,
                                  'title' => $title));
      ?>

  	</div>

    <div class="W73_100 float-left">

      <p style="margin: 10px 0; text-align: right; padding: 10px">Risultati <?php echo $start ?> - <?php echo $start + $rows - 1 ?> su 
         <?php echo $num ?> per <strong><?php echo $query ?></strong> <?php echo $title ?> (<?php echo $qTime ?>ms)</p>

      <div class="tabbed float-container" id="content">
      	<div id="main">
      	  <div class="W100_100 float-left" style="margin-bottom: 20px">

            <ol start="<?php echo $pager->getFirstIndice() ?>" class="search-results">
              <?php foreach ($pager->getResults() as $result): ?>
                <li><?php include_search_result($result, $query) ?></li>
              <?php endforeach ?>
            </ol>

            <?php echo pager_navigation($pager, "@votazioniSearch?query=$query") ?>


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
