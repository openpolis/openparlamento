<?php if ($atto->getTipoAttoId()<12) : ?>

<table class="signers">
  <thead>
    <tr>
      <th scope="col"><h5 class="subsection ico-first-signers">primi firmatari:</h5></th>
      
      <?php if ($atto->getTipoAttoId()==1) : ?>
          <th scope="col"><h5 class="subsection ico-co-signers">relatori:</h5></th>
      <?php endif; ?>    
    </tr>
  </thead>

  <tbody>
  <tr style="caption-side:top;">
  <td>
    <p class="tools-container"><?php echo link_to("che cosa sono i firmatari", '#', array( 'class'=>'ico-help')) ?></p>
    <div class="help-box float-container" style="display: none;">
    <div class="inner float-container">
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close')) ?>
    <h5>che cosa sono i firmatari ?</h5>
    <p>Il <b>primo firmatario</b> &egrave; il presentatore di un atto e vi appongone la propria firma assumendosene la responsabilit&agrave; diretta eventualmente anche insieme ad altri.<br />
    Il <b>cofirmatario</b> sostiene un atto presentato da altri (primo firmatario) aggiungendo la sua firma. </p>
  </div>
  </div>
  </td>
  <?php if ($atto->getTipoAttoId()==1) : ?>
  <td>
  <p class="tools-container"><?php echo link_to("che cosa sono i relatori", '#', array( 'class'=>'ico-help')) ?></p>
    <div class="help-box float-container" style="display: none;">
    <div class="inner float-container">
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close')) ?>
    <h5>che cosa sono i relatori ?</h5>
    <p>E' colui che viene incaricato di illustrare un Disegno di Legge - DDL - (o altro atto) per introdurre la discussione nell'Aula della Camera o del Senato.<br />
     Il Relatore ha poi la responsabilit&agrave; di seguire da vicino tutto l'iter del DDL sino alla sua approvazione.</p>
  </div>
  </div>
  </td>
  <?php endif; ?> 
  </tr>
    <?php if(count($primi_array_index) > count($rel_array_index)): ?>
      <?php $rel_index = 0 ?> 
      <?php foreach($primi_firmatari as $id => $primo_firmatario): ?> 	
      <?php $info_array = explode('*', $primo_firmatario ); //inizialmente era prevista anche la data (in $info_array[0]) ?>   
        <tr>
          <td><?php echo link_to(image_tag(OppPoliticoPeer::getThumbUrl($id), array('width'=>'40')).$info_array[1], '@parlamentare_old?id='.$id) ?></td>	
          <td>
            <?php if($rel_index < count($relatori)): ?>
		      <?php $ind = $rel_array_index[$rel_index]; ?>
		      <?php echo link_to(image_tag(OppPoliticoPeer::getThumbUrl($ind), array('width'=>'40')).$relatori[$ind], '@parlamentare_old?id='.$ind) ?>  
			  <?php $rel_index++; ?>
		    <?php endif; ?>            	
          </td>
        </tr>
      <?php endforeach; ?>	  
    <?php else: ?>
      <?php $primi_index = 0 ?>
      <?php foreach($relatori as $id => $relatore): ?>
        <tr>
          <td>
            <?php if($primi_index < count($primi_firmatari)): ?>
              <?php $ind = $primi_array_index[$primi_index] ?>			
			  <?php $info_array = explode('*', $primi_firmatari[$ind] ); ?>
			  <?php echo link_to(image_tag(OppPoliticoPeer::getThumbUrl($ind), array('width'=>'40')).$info_array[1], '@parlamentare_old?id='.$ind) ?>
			  <?php $primi_index++; ?>
			<?php endif; ?>  	
          </td>
		  <td>
		    <?php echo link_to(image_tag(OppPoliticoPeer::getThumbUrl($id), array('width'=>'40')).$relatore, '@parlamentare_old?id='.$id) ?>	
		  </td>
		</tr>  	       
	  <?php endforeach; ?>		  	        
    <?php endif; ?>
  </tbody>
</table>
<?php endif; ?>