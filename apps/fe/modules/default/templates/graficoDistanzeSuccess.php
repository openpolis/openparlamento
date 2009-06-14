<?php use_helper('I18N', 'Date') ?> 

<ul id="content-tabs" class="float-container tools-container">
   <li class="<?php echo($tipo=='votes_16_C' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Le distanze tra i Deputati', '@grafico_distanze?tipo=votes_16_C') ?></h2>   
  </li><li class="<?php echo($tipo=='votes_16_S' ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Le distanze tra i Senatori', '@grafico_distanze?tipo=votes_16_S') ?></h2>   
  </li>
</ul>

<div id="content" class="tabbed float-container">
<div id="main" style="width: 870px;">
<p class="tools-container" style="padding: 10px;"><a href="#" class="ico-help">cos'&egrave; il grafico delle distanze</a></p>
<div style="display: block;" class="help-box float-container float-left">
  <div class="inner float-container">
    <a href="#" class="ico-close">chiudi</a>	   	  
    <h5>cos'&egrave; il grafico delle distanze ?</h5> 
<p>
Il grafico mostra le distanze tra i <?php echo ($tipo=="votes_16_C" ? 'deputati' : 'senatori') ?> ricavate confrontando i voti espressi nelle 
<?php if ($tipo=="votes_16_C") : ?>
   <b><?php echo OppVotazionePeer::doSelectCountVotazioniPerPeriodo('','','16','C') ?> votazioni elettroniche d'aula finora svolte (ultima votazione del <?php echo format_date(OppVotazionePeer::doSelectDataUltimaVotazione('','','16','C'), 'dd/MM/yyyy') ?>).</b>
<?php else : ?>
   <b><?php echo OppVotazionePeer::doSelectCountVotazioniPerPeriodo('','','16','S') ?> votazioni elettroniche d'aula finora svolte (ultima votazione del <?php echo format_date(OppVotazionePeer::doSelectDataUltimaVotazione('','','16','S'), 'dd/MM/yyyy') ?>).</b>
<?php endif; ?><br />
Esplorando l'immagine si scopre come i <?php echo ($tipo=="votes_16_C" ? 'deputati' : 'senatori') ?> si distribuiscono nello spazio in base ai loro voti. Si possono notare le distanze tra
le nuvole di colore omogeneo ognuna delle quali corrisponde ad un gruppo parlamentare diverso ma anche verificare all'interno della stessa nuvola (gruppo) le prossimit&agrave; e le lontananze di voto tra
un parlamentare e l'altro.<br />
Prende forma in questo modo uno spazio politico inedito in cui &egrave; possibile confrontare e verificare,
con <?php echo link_to('approssimazione affidabile','/static/faq#11a') ?>, i comportamenti di voto di singoli rappresentanti e gruppi.
Uno spazio in cui le coordinate geografiche (destra/sinistra e alto/basso) non contano nulla e in cui
semplicemente chi vota nello stesso modo si trova pi&ugrave; vicino e chi vota in maniera difforme &egrave; pi&ugrave; lontanto.<br />
Presidenti e Vice-Presidenti di Camera e Senato e i parlamentari che ricoprono incarichi di governo
partecipano molto meno degli altri alle votazioni pertanto la loro collocazione nello spazio del grafico
risulta condizionata in misura proporzionata al numero di voti espressi e tendenzialmente vanno a
collocarsi nello spazio centrale, equidistante dagli estremi.
</p>
  </div>
</div>
<div id="distanceGraph">
<div class="intro-box">
<br/>
<h5 class="subsection">
OOPS! .... per visualizzare il grafico delle distanze<br /><br />&egrave; necessario <a href="http://get.adobe.com/flashplayer/">installare il Flash player </a>versione 9 o superiore</h5>
</div>
</div>
</div>
</div>
<?php $swfname = $tipo == "votes_16_S" ? "/swf/DistanceGraph" : "/swf/DistanceGraph" ?>
		<script type="text/javascript">
			var flashvars = {};
			flashvars.xmlfilepath = "/posizioni/opp_<?php echo($tipo) ?>.xml";
			flashvars.imgfilepath = "http://op_openparlamento_images.s3.amazonaws.com/parlamentari/thumb/";
			flashvars.linkfilepath = "/parlamentare/";
			var params = {};
			params.play = "true";
			params.scale = "noscale";
			params.wmode = "gpu";
			params.devicefont = "true";
			var attributes = {};
			swfobject.embedSWF("<?php echo($swfname) ?>.swf", "distanceGraph", "870", "540", "9.0.0", "/swf/expressInstall.swf", flashvars, params, attributes);
		</script>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
    le distanze tra i parlamentari  
<?php end_slot() ?>
