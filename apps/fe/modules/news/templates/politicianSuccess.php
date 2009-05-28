<?php use_helper('PagerNavigation', 'DeppNews') ?>
<?php setlocale(LC_TIME,"it_IT") ?>


<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <li><?php echo link_to('pagina di ' . $politician, '@parlamentare?id='.$politician_id) ?></li>
            <?php if ($sf_user->isAuthenticated()): ?>
              <li><?php echo link_to('i parlamentari monitorati', 'monitoring/politicians') ?></li>              
            <?php endif ?>
          </ul>
        </div>
      </div>      
    </div>
    
   <div class="W73_100 float-left">
    <h4 class="subsection">Tutte le notizie relative
   <?php if ($carica) : ?>
    <?php if($carica->getTipoCaricaId() !=1 ): ?>
      <?php echo " al Sen. " ?>
    <?php else: ?>
      <?php echo " all'On. " ?>
    <?php endif; ?> 
   <?php endif; ?>   
   <?php echo $politician ?><?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '@feed_politico?id='.$politician_id, array('style' => 'vertical-align:middle; padding:5px;')) ?></h4>
   <p style="padding: 5px; font-size:14px;">Ci sono <strong><?php echo $pager->getNbResults() ?></strong> notizie. Sono visualizzate cronologicamente dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>.</p>

   <table class="table-news">
      <?php foreach ($pager->getGroupedResults() as $date_ts => $news): ?>
        <?php $primo_item=1 ?>
      <?php echo ($primo_item==1 ? '<tr class="data"><td>&nbsp;</td></tr>' : '') ?>
      <tr>
      <?php if ($date_ts > 0): ?>
             <?php $primo_item=1 ?>
           <td style="width: 80px;">
           <div class="news-time">
	    <strong class="day"><?php echo date("d", $date_ts); ?></strong>
            <strong class="month"><?php echo strftime("%b", $date_ts); ?></strong>
            <strong class="year"><?php echo date("Y", $date_ts); ?></strong>
          </div> 
          </td> 
          <?php else: ?>
            <?php $primo_item=1 ?>
           <td style="width: 80px;">
           <div class="news-time">
           <strong class="day">NO</strong>
           <strong class="month">data</strong>
           <strong class="year"></strong>
          </div>  
          </td> 
       <?php endif ?>
          
          
          <?php foreach ($news as $n): ?>
          <?php if($primo_item==0) echo "<tr><td>&nbsp;</td>" ?>
            <?php echo news_text($n,2) ?>
             <?php $primo_item=0 ?>
            </tr>  
          <?php endforeach ?>

      <?php endforeach; ?>
    </table> 
   </div> 

    <?php echo pager_navigation($pager, '@news_parlamentare?id='.$politician_id, true, 7) ?>

  </div>
 </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php if ($carica) : ?>
   <?php if($carica->getTipoCaricaId() !=1 ): ?>
    <?php echo link_to('senatori', '@parlamentari?ramo=senato') ?> /
    Sen. 
   <?php else: ?>
    <?php echo link_to('deputati', '@parlamentari?ramo=camera') ?> /
    On.
   <?php endif; ?>
   <?php endif; ?> 
  <?php echo link_to($politician,'@parlamentare?id='.$politician_id) ?> /
   tutte le notizie
<?php end_slot() ?>