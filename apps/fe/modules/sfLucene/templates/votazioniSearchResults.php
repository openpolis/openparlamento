<?php use_helper('sfLucene', 'I18N', 'PagerNavigation') ?>

<?php include_partial('votazione/tabs') ?>

<div id="content" class="tabbed float-container">

  <div id="main">
    <div class="W25_100 float-right">
      <?php 
        echo include_partial('sfLucene/votazioni_controls', 
                            array('query' => $query,
                                  'title' => $title));
      ?>

  	</div>

    <div class="W73_100 float-left">

      <p>Ricerca per <strong><i><?php echo $query?></i></strong> <?php echo $title?></p>

      <div class="tabbed float-container" id="content">
      	<div id="main">
      	  <div class="W100_100 float-left" style="margin-bottom: 20px">

            <p>Ci sono <strong><?php echo $num ?></strong> risultati per la tua ricerca</p>

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

<?php slot('search_breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  <?php echo link_to('Votazioni', '@votazioni') ?> / 
  Risultati della ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>
