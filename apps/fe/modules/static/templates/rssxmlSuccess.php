<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Rss/xml
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container"> 

  <div id="main"> 

    <div class="W73_100 float-left" style="padding:5px; font-size:14px; line-height:1,5em;">
 
<br />  			
<p>In openparlamento sono disponibili numerosi <?php echo link_to('Rss','http://it.wikipedia.org/wiki/Really_simple_syndication') ?>, alcuni di carattere generale altri pi&ugrave; specifici.</p>
<br />
<p><em class="open" style="padding:5px; font-size:16px;"><strong>Rss generali</strong></em></p>
<p><?php echo link_to('»&nbsp;notizie principali dal Parlamento '.image_tag('/images/ico-rss.png'),'@feed') ?></p>
<p><?php echo link_to('»&nbsp;ultime notizie sui disegni di legge '.image_tag('/images/ico-rss.png'),'/feed/disegni') ?></p>
<p><?php echo link_to('»&nbsp;ultime notizie sui decreti legge '.image_tag('/images/ico-rss.png'),'/feed/decreti') ?></p>
<p><?php echo link_to('»&nbsp;ultime notizie sugli atti non legislativi '.image_tag('/images/ico-rss.png'),'/feed/attiNonLegislativi') ?></p>
<p><?php echo link_to('»&nbsp;ultimi post del blog  '.image_tag('/images/ico-rss.png'),'/sfSimpleBlog/postsFeed') ?></p>
<p><?php echo link_to('»&nbsp;ultimi commenti del blog '.image_tag('/images/ico-rss.png'),'sfSimpleBlog/commentsFeed/format/rss') ?></p>

<br />
<p><em class="open" style="padding:5px; font-size:16px;"><strong>Rss specifici</strong></em></p>
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