<?php if ($sotto>0 || $salva>0 || $ribelle>0) : ?>

<h5 class="subsection-alt" style="margin-top:0px;">Il comportamento nelle votazioni <span class="tools-container"><?php echo image_tag('/images/ico-new.png') ?></span></h5>

<br />	
<?php if ($ribelle>0) : ?>
    <div style="font-size:16px; margin-bottom:10px;">
      Ha votato <?php echo link_to($ribelle.' volte', '@parlamentare_voti?id='.$carica->getPoliticoId().'&slug='.$parlamentare->getSlug().'&filter_vote_rebel=1') ?> (<?php echo number_format($ribelli_perc, 2) ?>%&nbsp;sul totale dei voti) <strong>differentemente dal proprio gruppo</strong> parlamentare (voti ribelli).
      <span class="tools-container"><a class="ico-help" href="#" style="text-decoration:none">&nbsp;</a></span>
			<div style="display: none;" class="help-box float-container">
				<div class="inner float-container">		
					<a class="ico-close" href="#">chiudi</a><h5>quando un parlamentare &egrave; ribelle ?</h5>
					<p>Un parlamentare &egrave; considerato ribelle quando esprime un voto diverso da quello del gruppo parlamentare a cui appartiene. Si tratta di un indicatore puramente quantitativo del grado di ribellione alla "disciplina" del gruppo.</p>
				</div>
			</div>
    </div> 
<?php endif; ?>
<!-- 
<?php if ($sotto>0) : ?>
  <div style="font-size:16px; margin-bottom:10px;">
      In <?php echo link_to($sotto.' votazioni', '@parlamentare_voti?id='.$carica->getPoliticoId().'&slug='.$parlamentare->getSlug().'&filter_vote_rebel=2') ?> ha <strong>fatto battere la maggioranza di Governo</strong> con assenze o voti diversi da quelli del proprio gruppo.
      <span class="tools-container"><a class="ico-help" href="#" style="text-decoration:none">&nbsp;</a></span>
			<div style="display: none;" class="help-box float-container">
				<div class="inner float-container">		
					<a class="ico-close" href="#">chiudi</a><h5>che sono i voti con maggioranza battuta ?</h5>
					<p>Sono le votazioni elettroniche di aula (Camera e Senato) in cui la maggioranza parlamentare che sostiene il Governo &egrave; stata battuta (in gergo giornalistico "il Governo &egrave; andato sotto").<br/>
            Questi voti hanno una forte valenza politica, sono <i>segnali</i> che provengono dalla maggioranza stessa. Per questo &egrave; interessante scoprire come hanno votato i parlamentari e chi, in queste votazioni, &egrave; stato assente. <br/>
            Non sono state considerate le votazioni non elettroniche e quelle a scrutinio segreto.<br/>
            Il calcolo tiene conto dei cambiamenti delle maggioranze parlamentari e delle diverse appartenenze ai gruppi nel corso della legislatura. </p>
				</div>
			</div>
  </div>
<?php endif; ?>  
<?php if ($salva>0) : ?>
  <div style="font-size:16px; margin-bottom:10px;">
      In <?php echo link_to($salva.' votazioni', '@parlamentare_voti?id='.$carica->getPoliticoId().'&slug='.$parlamentare->getSlug().'&filter_vote_rebel=3') ?> ha <strong>salvato la maggioranza di Governo</strong> con assenze o voti diversi da quelli del proprio gruppo.
      <span class="tools-container"><a class="ico-help" href="#" style="text-decoration:none">&nbsp;</a></span>
			<div style="display: none;" class="help-box float-container">
				<div class="inner float-container">		
					<a class="ico-close" href="#">chiudi</a><h5>che sono i voti con maggioranza salvata ?</h5>
					<p>Sono le votazioni in cui la maggioranza di Governo &egrave; stata salvata dai voti e dalle assenze dei parlamentari di opposizione.<br/>
            In questi casi quindi se tutti i parlamentari di opposizione fossero stati presenti e avessero votato contro la maggioranza, quest'ultima sarebbe stata battuta nella votazione.<br/>
            Sono state prese in considerazione le votazioni elettroniche in Assemblea (di Camera e Senato) e tra queste solo quelle in cui lo schieramento di opposizione e quello di maggioranza hanno votato l’uno contro l’altro, come blocchi compattamente contrapposti, con posizioni omogenee tra i gruppi che sostengono il Governo, da un lato, e quelli che lo contrastano, dall’altro.<br/>
            In questo modo sono stati eliminati dal computo tutti quei casi di voti “bipartisan” o a maggioranza variabile, in cui si siano verificate composizioni e alleanze non canoniche su specifiche questioni.<br/>
            Pertanto restano solo su quei provvedimenti per i quali l’opposizione si è schierata unitariamente contro, o a favore, e tuttavia le assenze o i voti difformi dei singoli parlamentari dell'opposizione (voti ribelli rispetto il gruppo di appartenenza) hanno consentito alla maggioranza di Governo di vincere, e quindi di essere “salvata”, malgrado le molte assenze tra le proprie file (parlamentari in missione o assenti).<br/>
            Il calcolo tiene conto dei cambiamenti delle maggioranze parlamentari e delle diverse appartenenze ai gruppi nel corso della legislatura. 
            </p>
				</div>
			</div>
  </div>
<?php endif; ?>
-->

<?php endif; ?>