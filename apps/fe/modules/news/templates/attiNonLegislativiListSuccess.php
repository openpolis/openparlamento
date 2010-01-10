<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <li><?php echo link_to('Lista degli atti non legislativi', '@attiNonLegislativi') ?></li>
          </ul>
        </div>
      </div>      
    </div>

     <div class="W73_100 float-left">
      <h4 class="subsection">Tutte le notizie relative agli atti non legislativi<?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '@feed_attiNonLegislativi', array('style' => 'vertical-align:middle; padding:5px;')) ?></h4>
      <?php include_partial('filter',
                          array('selected_main_all' => array_key_exists('main_all', $filters)?$filters['main_all']:'main')) ?>
      <p style="padding: 5px; font-size:14px;">Ci sono <strong><?php echo $pager->getNbResults() ?></strong> notizie. Sono visualizzate cronologicamente dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>.</p>

      <?php echo include_partial('news/newslist',array('pager' => $pager, 'context' => CONTEXT_LIST)); ?>

      <?php echo pager_navigation($pager, 'news/attiNonLegislativiList') ?>
    </div>  


  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
    <?php echo link_to("atti non legislativi", "atto/attoNonLegislativoList") ?> /
   tutte le notizie
<?php end_slot() ?>