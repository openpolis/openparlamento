<?php if ($pagina=='keyvotes') : ?>
<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col"><br />sigla/titolo:</th>
      <th scope="col">esito in<br />Parlamento:</th>
      <th scope="col">voti di<br />scarto:</th>
      <th scope="col">numero di<br />ribelli:</th>
    </tr>
  </thead>

  <tbody>
   <?php $tr_class = 'even' ?>
    <?php foreach ($votazioni as $votazione): ?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?> - <span style="color:black;"><?php echo ($votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ) ?></span>, seduta n. <?php echo ($votazione->getOppSeduta()->getNumero() ) ?></span>
          </p>
          <p><?php echo link_to(($votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo()), '@votazione?'.$votazione->getUrlParams()) ?></p>
       </th>
        
	    <td>
		  <?php if($votazione->getEsito()=='APPROVATA'): ?>
		    <?php $class = "green thumb-approved"; ?>
		  <?php elseif($votazione->getEsito()=='RESPINTA'): ?>
		    <?php $class = "red thumb-rejected"; ?>
		  <?php else: ?>
		    <?php $class = ""; ?>
          <?php endif; ?>					
		  <span class="<?php echo $class ?>"><?php echo $votazione->getEsito() ?></span>
		</td>
        <td><p><?php echo $votazione->getMargine() ?></p></td>
        <td><p><?php echo $votazione->getRibelli() ?></p></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
 		  		
</table>
<?php endif; ?>

<?php if ($pagina=='homepage') : ?>
  <?php if (count($votazioni)>0) : ?>
    <div class="section-box">
      <h3 class="section-box-no-rss">voti chiave <span class="tools-container"><?php echo image_tag('/images/ico-new.png') ?><a class="ico-help" href="#">&nbsp;</a></span>	
      
  			<div style="display: none;" class="help-box float-container">
  				<div class="inner float-container" style="font-size:12px;">		
  					<a class="ico-close" href="#">chiudi</a><h5>cosa sono i voti chiave ?</h5>
  					<p>Sono le votazioni pi&ugrave; importanti della legislatura sia per la rilevanza della materia trattata, sia per il valore politico del voto.</p>
  				</div>
  			</div>
  </h3>			
  					
	<ul id="law-n-acts-proposals">
	  <?php foreach ($votazioni as $votazione): ?>
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
	  <p><?php echo link_to(($votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo()), '@votazione?'.$votazione->getUrlParams()) ?></p>
	 </li>	
	  <?php endforeach; ?>
	</ul>
	<div class="section-box-scroller tools-container has-next" style="padding-top:10px; padding-bottom:20px;">
          <a href="<?php echo url_for('@votichiave'); ?>" class="see-all"><strong>vai a tutti i voti chiave</strong></a>
        </div>			
    </div>
   
  <?php endif; ?>
<?php endif; ?>