<?php use_helper('I18N', 'Date') ?>


<?php include_partial('tabs', array('current' => 'maggioranza_salva')) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
<?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>    
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
      <?php include_partial('wikiMaggioranzaSalva') ?>  	  
      
      
      <h6 style="padding:10px 0 5px 0;">In questa legislatura la maggioranza parlamentare che sostiene il Governo &egrave; stata salvata in <?php echo $pager->getNbResults() ?> votazioni elettroniche d'aula di Camera e Senato dai voti e dalle assenze dei parlamentari di opposizione.</h6>		
      
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
    
    <?php else :?>
      pagina in costruzione
    <?php endif; ?>
    
  </div>
</div>



<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  voti con maggioranza salvata
<?php end_slot() ?>