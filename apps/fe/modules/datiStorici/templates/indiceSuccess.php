<?php include_partial('tabs', array('current' => 'indice')) ?>

<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">

    <?php include_partial('indiceFilter',
                          array('date' => $all_dates,
                                'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),
                                'selected_ramo' => array_key_exists('ramo', $filters)?$filters['ramo']:0,
                                'selected_data' => array_key_exists('data', $filters)?$filters['data']:0)) ?>
                                
    <?php include_partial('indiceSort') ?>
                                

    <?php echo include_partial('default/listNotice', 
                               array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

    <?php include_partial('indiceList', array('pager' => $pager)) ?>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> / dati storici su indice attivit&agrave;
<?php end_slot() ?>
