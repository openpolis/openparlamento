<?php use_helper('I18N', 'Date') ?>


<?php include_partial('tabs', array('current' => 'maggioranza_salva')) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <?php echo include_partial('secondLevelVotiMaggioranzaSalva', 
                               array('current' => 'lista')); ?>
                               
    <div class="W25_100 float-right">
      <?php include_partial('votazioneRightColumn', array('query' => $query)) ?>  
       <p align=center>
         <strong>
           vedi anche:</strong><br/>
         <?php echo link_to('I <strong>deputati</strong> che hanno salvato la maggioranza', '@parlamentariSalva?ramo=camera') ?>
         <br/>
         <?php echo link_to('I <strong>senatori</strong> che hanno salvato la maggioranza', '@parlamentariSalva?ramo=senato') ?>
        
      </p>
    </div>
    <div class="W73_100 float-left">	  
      <p style="padding:10px 0 5px 0; font-size:16px;">
        In questa legislatura la maggioranza che sostiene il Governo &egrave; stata salvata in <?php echo number_format($pager->getNbResults() , 0, ',', '.');?> votazioni (su un totale di <?php echo number_format(OppVotazionePeer::doSelectCountVotazioniPerPeriodo('', '', 16, 'C')+OppVotazionePeer::doSelectCountVotazioniPerPeriodo('', '', 16, 'S'), 0, ',', '.') ?> voti) dai voti e dalle assenze dei parlamentari di opposizione.<br/>
        <?php include_partial('wikiMaggioranzaSalva') ?>  
      </p>		
      
      <?php include_partial('filter',
                            array('tags_categories' => $all_tags_categories,
                                  'active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),                            
                                  'selected_type' => array_key_exists('type', $filters)?$filters['type']:0,                                
                                  'selected_tags_category' => array_key_exists('tags_category', $filters)?$filters['tags_category']:0,
                                  'selected_ramo' => array_key_exists('ramo', $filters)?$filters['ramo']:0,
                                  'selected_esito' => array_key_exists('esito', $filters)?$filters['esito']:0)) ?>
    
      

      <?php echo include_partial('default/listNotice', array('filters' => $filters, 'results' => $pager->getNbResults())); ?>

      <?php include_partial('maggioranzaSalva', array('pager' => $pager)) ?>  
    </div>
    <div class="clear-both"></div>
    
  </div>
</div>



<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  voti con maggioranza salvata
<?php end_slot() ?>