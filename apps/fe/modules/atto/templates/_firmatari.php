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
    <?php if(count($primi_array_index) > count($rel_array_index)): ?>
      <?php $rel_index = 0 ?> 
      <?php foreach($primi_firmatari as $id => $primo_firmatario): ?> 	
      <?php $info_array = explode('*', $primo_firmatario ); //inizialmente era prevista anche la data (in $info_array[0]) ?>   
        <tr>
          <td><?php echo link_to(image_tag(OppPoliticoPeer::getThumbUrl($id), array('width'=>'40')).$info_array[1], '@parlamentare?id='.$id) ?></td>	
          <td>
            <?php if($rel_index < count($relatori)): ?>
		      <?php $ind = $rel_array_index[$rel_index] ?>
		      <?php echo link_to(image_tag(OppPoliticoPeer::getThumbUrl($ind), array('width'=>'40')).$relatori[$ind], '@parlamentare?id='.$ind) ?>  
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
			  <?php echo link_to(image_tag(OppPoliticoPeer::getThumbUrl($ind), array('width'=>'40')).$info_array[1], '@parlamentare?id='.$ind) ?>
			  <?php $primi_index++; ?>
			<?php endif; ?>  	
          </td>
		  <td>
		    <?php echo link_to(image_tag(OppPoliticoPeer::getThumbUrl($id), array('width'=>'40')).$relatore, '@parlamentare?id='.$id) ?>	
		  </td>
		</tr>  	       
	  <?php endforeach; ?>		  	        
    <?php endif; ?>
  </tbody>
</table>
<?php endif; ?>