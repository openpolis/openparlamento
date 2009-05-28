<?php use_helper('PagerNavigation', 'DeppNews') ?>
<?php setlocale(LC_TIME,"it_IT") ?>

<div id="content" class="float-container">
  <div id="main" class="monitored_acts monitoring">

    <div class="W25_100 float-right">
      <div class="section-box">
        <h6>Collegamenti</h6>
        <div class="float-container">
          <ul>
            <li><?php echo link_to('pagina dell\'atto '.$act->getRamo().'.'.$act->getNumfase(), '@singolo_atto?id='.$act_id) ?></li>
            <?php if ($sf_user->isAuthenticated()): ?>
              <li><?php echo link_to('DDL e Atti monitorati', 'monitoring/acts') ?></li>              
            <?php endif ?>
          </ul>
        </div>
      </div>      
    </div>
    
   <div class="W73_100 float-left">
    <h4 class="subsection">Tutte le notizie su <?php echo $act->getOppTipoAtto()->getDescrizione().' '.$act->getRamo().'.'.$act->getNumfase().' '.$act->getTitolo() ?><?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS')), '@feed_atto?id='.$act_id, array('style' => 'vertical-align:middle; padding:5px;')) ?></h4>
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
            <?php echo news_text($n,0) ?>
            <?php $primo_item=0 ?>
           </tr>  
          <?php endforeach ?>
        
      <?php endforeach; ?>
     </table>
    </div> 

    <?php echo pager_navigation($pager, '@news_atto?id='.$act_id, true, 7) ?>
    
   </div>
  </div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php if ($act->getTipoAttoId()==1): ?>
	<?php echo link_to("disegni di legge", "atto/disegnoList") ?>
    <?php endif; ?> 
    	
    <?php if ($act->getTipoAttoId()==12): ?>
	<?php echo link_to("decreti legge", "atto/decretoList") ?>
    <?php endif; ?> 
    
    <?php if ($act->getTipoAttoId()==15 || $act->getTipoAttoId()==16 || $act->getTipoAttoId()==17): ?>
	<?php echo link_to("decreti legislativi", "atto/decretoLegislativoList") ?>
    <?php endif; ?> 
    
    <?php if (($act->getTipoAttoId()<12 && $act->getTipoAttoId()!=1) || $act->getTipoAttoId()==14): ?>
	<?php echo link_to("atti non legislativi", "atto/attoNonLegislativoList") ?>
    <?php endif; ?> 

    /
    <?php echo link_to(Text::denominazioneAttoShort($act),'@singolo_atto?id='.$act_id) ?> /
    tutte le notizie

     
<?php end_slot() ?>