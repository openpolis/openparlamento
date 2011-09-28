  <?php if (count($sotto)>0 || count($salva)>0) : ?>		  
  <div class="section-box" style="padding-bottom:20px;">
    <h3 class="section-box-no-rss">Ultimi voti con maggioranza <span style="color:red;">battuta</span> o <span style="color:green;">salvata</span> <span class="tools-container"><?php echo image_tag('/images/ico-new.png') ?><a class="ico-help" href="#">&nbsp;</a></span>	
    
			<div style="display: none;" class="help-box float-container">
				<div class="inner float-container" style="font-size:12px;">		
					<a class="ico-close" href="#">chiudi</a><h5>cosa sono i voti con maggioranza battuta o salvata ?</h5>
					<p>Le votazioni con <span style="color:red;">maggioranza battuta</span> sono quelle in cui la maggioranza parlamentare che sostiene il Governo &egrave; stata battuta (in gergo giornalistico "il Governo &egrave; andato sotto").<br/>
            Questi voti hanno una forte valenza politica, sono <i>segnali</i> che provengono dalla maggioranza stessa. Per questo &egrave; interessante scoprire come hanno votato i parlamentari e chi, in queste votazioni, &egrave; stato assente. <br/>
            Non sono state considerate le votazioni non elettroniche e quelle a scrutinio segreto.</p>
            <p>Le votazioni con <span style="color:red;">maggioranza salvata</span> sono quelle in cui la maggioranza di Governo &egrave; stata salvata dai voti e dalle assenze dei parlamentari di opposizione.<br/>
              In questi casi quindi se tutti i parlamentari di opposizione fossero stati presenti e avessero votato contro la maggioranza, quest'ultima sarebbe stata battuta nella votazione.<br/>
              Sono state prese in considerazione le votazioni elettroniche in Assemblea (di Camera e Senato) e tra queste solo quelle in cui lo schieramento di opposizione e quello di maggioranza hanno votato l’uno contro l’altro, come blocchi compattamente contrapposti, con posizioni omogenee tra i gruppi che sostengono il Governo, da un lato, e quelli che lo contrastano, dall’altro.<br/>
              In questo modo sono stati eliminati dal computo tutti quei casi di voti “bipartisan” o a maggioranza variabile, in cui si siano verificate composizioni e alleanze non canoniche su specifiche questioni.<br/>
              Pertanto restano solo su quei provvedimenti per i quali l’opposizione si è schierata unitariamente contro, o a favore, e tuttavia le assenze o i voti difformi dei singoli parlamentari dell'opposizione (voti ribelli rispetto il gruppo di appartenenza) hanno consentito alla maggioranza di Governo di vincere, e quindi di essere “salvata”, malgrado le molte assenze tra le proprie file (parlamentari in missione o assenti).
              </p>
				</div>
			</div>
</h3>
  <?php if (count($sotto)>0) : ?>		
  					
	<ul id="law-n-acts-proposals">
	  <p style="margin-bottom:10px; margin-left:8px;">Ultimi voti in cui la <strong style="color:red;">maggioranza è stata battuta</strong> (<a href="/votazioni/keyvotes" class="see-all">vedi tutte le altre <?php echo number_format(count($sotto), 0, ',', '.')?> votazioni</a>)</p>
	  <?php foreach ($sotto as $k=>$votazione): ?>
	    <?php if ($k<$limit) :?>
	      <li class="float-container">
	        <p style="color: #BEBEBE;font-size:11px;font-weight:bold;">
	          <?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?> - <span style="color:black;"><?php echo ($votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ) ?></span>, seduta n. <?php echo ($votazione->getOppSeduta()->getNumero() ) ?>
	        </p>			
	      <div class="user-votes">
	      <?php if($votazione->getEsito()=='APPROVATA'): ?>
		      <?php $class = "green thumb-approved"; ?>
		    <?php elseif($votazione->getEsito()=='RESPINTA'): ?>
		      <?php $class = "red thumb-rejected"; ?>
		    <?php else: ?>
		      <?php $class = ""; ?>
	      <?php endif; ?>	
	      <span class="<?php echo $class ?>"><?php echo $votazione->getEsito() ?></span>      
	      </div>					
	      <p><?php echo link_to(($votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo()), '@votazione?id='.$votazione->getId()) ?></p>
	    </li>	
	    <?php endif; ?>
	  <?php endforeach; ?>
	  </ul>
   
  <?php endif; ?>
  
  <?php if (count($salva)>0) : ?>		
  					
	<ul id="law-n-acts-proposals">
	  <p style="margin-bottom:10px; margin-left:8px;">Ultimi voti in cui la <strong style="color:green;">maggioranza è stata salvata</strong> (<a href="/votazioni/keyvotes" class="see-all">vedi tutte le altre <?php echo number_format(count($salva), 0, ',', '.')?> votazioni</a>)</p>
	  <?php foreach ($salva as $k=>$votazione): ?>
	    <?php if ($k<$limit) :?>
	      <li class="float-container">
	        <p style="color: #BEBEBE;font-size:11px;font-weight:bold;">
	          <?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?> - <span style="color:black;"><?php echo ($votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ) ?></span>, seduta n. <?php echo ($votazione->getOppSeduta()->getNumero() ) ?>
	        </p>			
	      <div class="user-votes">
	      <?php if($votazione->getEsito()=='APPROVATA'): ?>
		      <?php $class = "green thumb-approved"; ?>
		    <?php elseif($votazione->getEsito()=='RESPINTA'): ?>
		      <?php $class = "red thumb-rejected"; ?>
		    <?php else: ?>
		      <?php $class = ""; ?>
	      <?php endif; ?>	
	      <span class="<?php echo $class ?>"><?php echo $votazione->getEsito() ?></span>      
	      </div>					
	      <p><?php echo link_to(($votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo()), '@votazione?id='.$votazione->getId()) ?></p>
	    </li>	
	    <?php endif; ?>
	  <?php endforeach; ?>
	  </ul>
   
  <?php endif; ?>
  
  </div>
  <?php endif; ?>  