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
<div style="display: none;" class="help-box float-container float-left">
  <div class="inner float-container">
    <a href="#" class="ico-close">chiudi</a>	   	  
    <h5>cos'&egrave; il grafico delle distanze ?</h5> 
<p>
Il grafico mostra le distanze tra i <?php echo ($tipo=="votes_16_C" ? 'deputati' : 'senatori') ?> ricavate confrontando i voti espressi nelle <br/> 
<?php if ($tipo=="votes_16_C") : ?>
   <b><?php echo OppVotazionePeer::doSelectCountVotazioniPerPeriodo('','','16','C') ?> votazioni elettroniche d'aula finora svolte (ultima votazione del <?php echo format_date(OppVotazionePeer::doSelectDataUltimaVotazione('','','16','C'), 'dd/MM/yyyy') ?>).</b>
<?php else : ?>
   <b><?php echo OppVotazionePeer::doSelectCountVotazioniPerPeriodo('','','16','S') ?> votazioni elettroniche d'aula finora svolte (ultima votazione del <?php echo format_date(OppVotazionePeer::doSelectDataUltimaVotazione('','','16','S'), 'dd/MM/yyyy') ?>).</b>
<?php endif; ?>   
<br />Si vuole mostrare quali <?php echo ($tipo=="votes_16_C" ? 'deputati' : 'senatori') ?> tra di loro sono vicini e quali lontani.<br />
Un calcolo non ideologico, che parte da dati oggettivi: i voti d'aula effettivi espressi da ciascuno.<br /><br />
Naturalmente il grafico mostra solo un'approssimazione, seppur affidabile, delle distanze.<br />
Il grafico <b>non mostra</b> quali sono i <?php echo ($tipo=="votes_16_C" ? 'deputati' : 'senatori') ?> di destra e di sinistra, quelli liberali e quelli statalisti.<br />
In questo caso destra/sinistra, in alto/in basso non hanno alcun significato.
<br /> <b>Conta soltanto la distanza di ogni <?php echo ($tipo=="votes_16_C" ? 'deputato' : 'senatore') ?> dagli altri!</b>
</p>
  </div>
</div>
<div id="distanceGraph">


</div>
</div>
</div>
<?php $swfname = $tipo == "votes_16_S" ? "/swf/DistanceGraph_S" : "/swf/DistanceGraph_C" ?>
		<script type="text/javascript">
			var flashvars = {};
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
