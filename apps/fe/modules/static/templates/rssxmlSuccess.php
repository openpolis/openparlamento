<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Rss/xml
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container"> 

  <div id="main"> 

    <div class="W73_100 float-left" style="padding:5px;">
    <p class="tools-container"><?php echo link_to('cosa sono gli rss', '#', array( 'class'=>'ico-help')) ?></p>
  <div class="help-box float-container" style="display: none;">
  <div class="inner float-container">
    <div class="go-wikipedia">
      <?php echo link_to('approfondisci su<br />'.image_tag('ico-wikipedia.png', array('alt' => 'wikipedia').'<strong>Wikipedia</strong>'), 'http://it.wikipedia.org/wiki/Progetto_di_legge') ?>
    </div>
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close')) ?>	   	  
    <h5>cosa sono gli rss ?</h5>
    <p>Il disegno (o progetto o proposta) di legge (DDL) &egrave; un testo suddiviso in articoli che viene presentato alla Camera o al Senato per essere esaminato, discusso e votato e infine per diventare legge. (approfondisci su: <?php echo link_to('Wikipedia', 'http://it.wikipedia.org/wiki/Progetto_di_legge') ?>)</p>
  </div>
</div>	  
<br />  			
<p>In openparlamento sono disponibili numerosi flussi rss, alcuni di carattere generale altri pi&ugrave; specifici.</p>
<br />
<p><b>Rss generali</b></p>
<p><?php echo link_to('»&nbsp;notizie principali dal Parlamento '.image_tag('/images/ico-rss.png'),'/feed/') ?></p>
<p><?php echo link_to('»&nbsp;ultime notizie sui disegni di legge '.image_tag('/images/ico-rss.png'),'/feed/disegni') ?></p>
<p><?php echo link_to('»&nbsp;ultime notizie sui decreti legge '.image_tag('/images/ico-rss.png'),'/feed/decreti') ?></p>
<p><?php echo link_to('»&nbsp;ultime notizie sugli atti non legislativi '.image_tag('/images/ico-rss.png'),'/feed/attiNonLegislativi') ?></p>
<p><?php echo link_to('»&nbsp;ultimi post del blog  '.image_tag('/images/ico-rss.png'),'/sfSimpleBlog/postsFeed') ?></p>
<p><?php echo link_to('»&nbsp;ultimi commenti del blog '.image_tag('/images/ico-rss.png'),'sfSimpleBlog/commentsFeed/format/rss') ?></p>

<br />
<p><b>Rss specifici</b></p>
<p>»&nbsp;ultime notizie su un parlamentare. Trovi il link al flusso rss nella pagina del parlamentare.</p>
<p>»&nbsp;ultime notizie su un atto (ddl, mozione, decreto legge, ...). Trovi il link al flusso rss nella pagina del singolo atto.</p>
<br />

    </div>
  </div>

</div> 

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  rss-xml
<?php end_slot() ?>