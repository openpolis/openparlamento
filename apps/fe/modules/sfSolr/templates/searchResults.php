<?php 
/** 
 * @package sfSolrPlugin
 * @subpackage Module
 * @author     Guglielmo Celata <g.celata@depp.it>
 */
?>

<?php use_helper('sfSolr', 'OppSolr', 'I18N', 'PagerNavigation') ?>

<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Risultati della ricerca per <em><?php echo $query ?></em></h2></li>
</ul>


<div class="tabbed float-container" id="content">
  <div id="main">
    <div class="W100_100 float-left">
      <?php echo include_partial('sfSolr/addAlert', array('query' => $query)); ?>
      
      <!-- sidebar per filtri a faccette e ordinamento -->
      <div id="facet_filters">

        
        <!-- filtri sul tipo di oggetto puntato dal risultato -->
        <ul>
          <li>
            <?php if ($type_filter == ''): ?>
              <strong>Tutti i tipi</strong>
            <?php else: ?>
                <?php echo link_to('Tutti i tipi', 
                                     $base_search_route . 
                                      ($date_filter != ''?"&date_filter=$date_filter":""), array()) ?>            
            <?php endif ?>
          </li>
          <?php foreach ($type_filters = array('Parlamentari' => 'politici',
                               'Disegni di legge' => 'disegni',
                               'Decreti legge' => 'decreti',
                               'Decreti legislativo' => 'decrleg',
                               'Emendamenti' => 'emendamenti',
                               'Mozioni' => 'mozioni',
                               'Interpellanze' => 'interpellanze',
                               'Interrogazioni' => 'interrogazioni',
                               'Risoluzioni' => 'risoluzioni',
                               'Ordini del giorno' => 'odg',
                               'Audizioni' => 'audizioni',
                               'Comunicati del Governo' => 'comunicazionigoverno',
                               'Votazioni' => 'votazioni',
                               'Argomenti' => 'argomenti',
                               'Resoconti stenografici' => 'resoconti'
                               ) as $label => $filter): ?>
             <li>
               <?php if ($type_filter == $filter): ?>
                <strong><?php echo $label ?></strong>
               <?php else: ?>
                 <?php echo link_to($label, 
                                      $base_search_route . 
                                        ($date_filter != ''?"&date_filter=$date_filter":"") .
                                        "&type_filter=$filter", array()) ?>
               <?php endif ?>
             </li>
          <?php endforeach ?>
        </ul>

        <hr/>

        <!-- filtri sulle date -->
        <ul>
          <li>
            <?php if ($date_filter == ''): ?>
              <strong>Qualsiasi data</strong>
            <?php else: ?>
                <?php echo link_to('Qualsiasi data', 
                                     $base_search_route . 
                                      ($type_filter != ''?"&type_filter=$type_filter":""), array()) ?>            
            <?php endif ?>
          </li>

          <?php foreach ($date_filters = array('Ieri e oggi' => 'today',
                               'Questa settimana' => 'week',
                               'Questo mese' => 'month',
                               'Questo semestre' => 'semester',
                               'Quest\'anno' => 'year') as $label => $filter): ?>
             <li>
               <?php if ($date_filter == $filter): ?>
                <strong><?php echo $label ?></strong>
               <?php else: ?>
                 <?php echo link_to($label, 
                                      $base_search_route . 
                                       ($type_filter != ''?"&type_filter=$type_filter":"") .
                                       "&date_filter=$filter", array()) ?>
               <?php endif ?>
             </li>
          <?php endforeach ?>          
        </ul>
        
        <hr/>

        <!-- ordinamento -->
        <ul>
          <li>
            <?php if ($sort == ''): ?>
              <strong>Ordina per rilevanza</strong>
            <?php else: ?>
                <?php echo link_to('Ordina per rilevanza', 
                                     $base_search_route . 
                                      ($date_filter != ''?"&date_filter=$date_filter":"") .
                                      ($type_filter != ''?"&type_filter=$type_filter":""), array()) ?>            
            <?php endif ?>
          </li>
          <li>
            <?php if ($sort == 'date'): ?>
              <strong>Ordina per data</strong>
            <?php else: ?>
                <?php echo link_to('Ordina per data', 
                                     $base_search_route . 
                                      ($date_filter != ''?"&date_filter=$date_filter":"") .
                                      ($type_filter != ''?"&type_filter=$type_filter":"") .
                                      "&sort=date", array()) ?>            
            <?php endif ?>
          </li>
        </ul>
        
      </div>


      <!-- risultati -->
      <div id="search_results">
        
        
        <?php if ($num > 0): ?>
          <p style="margin: 10px 0; padding: 5px; ">
            Risultati <?php echo $start ?> - <?php echo $start + $rows - 1 ?> su 
            <?php echo $num ?> per <strong><?php echo $query ?></strong> 
            (<?php echo $qTime ?>ms)
          </p>           

          <?php if ($date_filter != '' || $type_filter != '' || $sort != ''): ?>
            <div style="background: none repeat scroll 0% 0% rgb(235, 239, 249); margin-bottom: 1em; padding: 8px;">
              <?php echo link_to('Reimposta', $base_search_route, array('style' => 'float:right')) ?>
              Filtri:
              <?php if ($date_filter): ?>
                <?php  echo array_search($date_filter, $date_filters)?>
              <?php endif ?>
              <?php if ($date_filter && $type_filter): ?>+<?php endif ?>
              <?php if ($type_filter): ?>
                <?php  echo array_search($type_filter, $type_filters)?>
              <?php endif ?>
            </div>          
          <?php endif ?>

          <table class="search-results-table">
          <?php $num_item=0 ?>

            <?php foreach ($pager->getResults() as $result): ?>
              <?php $num_item=$num_item+1 ?>
              <tr>
                <td class="ico">
                  <div class="ico-type">
                    <?php include_search_result_icon($result) ?>                
                  </div>
                </td>

                <td class="text <?php echo (fmod($num_item,2)!=0) ? 'odd' : 'even' ?>">                      
                  <?php include_search_result($result, $query, array('num_item'=>$num_item)) ?>
                </td>

                <td class="score">
                  <div class="results-meter">
                    <div class="results-meter-value"><?php echo $result->getScore() ?>%</div>
                    <div class="results-meter-scale">
                      <div style="width: <?php echo $result->getScore() ?>%;" class="results-meter-bar"> </div>
                    </div>
                 </div>
                </td>

              </tr>
            <?php endforeach ?>
          </table>

        <?php else: ?>
          <div style="font-size: 14px;">
            <p style="margin-top: 0.33em;">
              La ricerca di - <b><?php echo $query ?></b> - non ha prodotto risultati. 
              <?php echo link_to('Reimposta gli strumenti di ricerca.', $base_search_route, array()) ?>
            </p>
            <p style="margin-top: 1em;">Suggerimenti:</p>
            <ul style="margin: 0pt 0pt 2em 1.3em;">
              <li>Assicurati che tutte le parole siano state digitate correttamente.</li>
              <li>Prova con parole chiave diverse.</li>
              <li>Prova con parole chiave più generiche.</li>
            </ul>            
          </div>

        <?php endif ?>

        <?php echo pager_navigation($pager, $pager_search_route) ?>
        
      </div>
      

    </div>
  </div>
</div>

<?php slot('search') ?>
  <?php include_search_controls($query) ?>
<?php end_slot() ?>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>



