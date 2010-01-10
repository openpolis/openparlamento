<?php use_helper('PagerNavigation', 'DeppNews') ?>
<?php setlocale(LC_TIME,"it_IT") ?>

<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
           <li>La pagina dell'argomento <?php echo link_to($tag,'@argomento?triple_value='.$tag) ?></li>
            <?php if ($sf_user->isAuthenticated()): ?>
              <li><?php echo link_to('Gestione argomenti monitorati', '@monitoring_tags?user_token='.$sf_user->getToken()) ?></li>              
            <?php endif ?>
          </ul>
        </div>
      </div>      
    </div>
    
    
    <div class="W73_100 float-left">
      <h4 class="subsection">Tutte le notizie relative all'argomento <?php echo $tag ?></h4>
    
      <p style="padding: 5px; font-size:14px;">
        Ci sono <strong><?php echo $pager->getNbResults() ?></strong> notizie. 
        Sono visualizzate cronologicamente dalla <?php echo $pager->getFirstIndice() ?> alla 
        <?php echo $pager->getLastIndice() ?>.</p>
    
        <?php echo include_partial('news/newslist', array('pager' => $pager, 'context' => CONTEXT_TAG)); ?>

        <?php echo pager_navigation($pager, 'news/tag?id='.$tag_id, true, 7) ?>

    </div>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php echo link_to("argomenti", "@argomenti") ?> /
    <?php echo link_to($tag,'@argomento?triple_value='.$tag) ?> /
    tutte le notizie   
<?php end_slot() ?>