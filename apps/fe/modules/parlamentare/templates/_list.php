<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col">parlamentare:</th>
      <th scope="col">indice di attivit&agrave;:</th> 	
      <th scope="col">voti ribelli:</th>			
      <th scope="col" class="evident">presenze:</th>			
      <th scope="col" class="evident">assenze:</th>
      <th scope="col" class="evident">missioni:</th>
      <th scope="col">circoscrizione:</th>
      <th scope="col">utenti che lo seguono:</th>
    </tr>
  </thead>

  <tbody>
  
    <?php $tr_class = 'even' ?>				  
    <?php while($parlamentari->next()): ?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th scope="row">
          <p class="politician-id">
            <?php //echo image_tag(OppPoliticoPeer::getThumbUrl($parlamentari->getInt(2)), 
                   //              array('width' => '40','height' => '53' )) ?>	
            <?php echo image_tag('/images/ico-type-politico-portrait.png', 
                                 array('width' => '40','height' => '53', 'highsrc' => OppPoliticoPeer::getThumbUrl($parlamentari->getInt(2))  )) ?>	
            <?php echo link_to($parlamentari->getString(3).' '.$parlamentari->getString(4), '@parlamentare?id='.$parlamentari->getInt(2)) ?>
            <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($parlamentari->getInt(1)) ?>  	
	        <?php foreach($gruppi as $nome => $gruppo): ?>
	          <?php if(!$gruppo['data_fine']): ?>
		        <?php print" (". $nome.")" ?>
	          <?php endif; ?> 
	     <?php endforeach; ?> 
	       <?php if($parlamentari->getInt(10)=='-1'): ?> 
		<br />cessato il <?php echo format_date($parlamentari->getDate(13, 'Y-m-d'), 'dd/MM/yyyy') ?> 
	     <?php endif; ?>
	     
	     <?php if($parlamentari->getString(14)>'2008-04-29'): ?> 
	       	<br /><small>in carica dal <?php echo format_date($parlamentari->getString(14), 'dd/MM/yyyy') ?></small>
	       <?php endif; ?>
          </p>
        </th>
        
        <td>
		  <?php if($parlamentari->getInt(10)!='-1'): ?>
                   <?php printf('<b>%01.2f</b><br /><span class="small">(%d° su %d)</span>', $parlamentari->getFloat(9), $parlamentari->getInt(10), $numero_parlamentari) ?> 
                  <?php else: ?>
		    <?php printf('<b>%01.2f</b> ', $parlamentari->getFloat(9)) ?>  
		  <?php endif; ?>
	</td>
        
        <td>
          <?php if($parlamentari->getInt(6)!=0 && $parlamentari->getInt(12)!=0): ?>
                <b><?php echo link_to($parlamentari->getInt(12),'@parlamentare_voti?id='.$parlamentari->getInt(2)."&filter_vote_rebel=1") ?></b>
	  <?php else: ?>
	        <?php print('<b>0</b>') ?>
	  <?php endif; ?>
        </td>    
        
	<?php $num_votazioni = $parlamentari->getInt(6) + $parlamentari->getInt(7) + $parlamentari->getInt(8) ?>
        <?php if($num_votazioni==0): ?>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span class="small">(0 su 0)</span>') ?>
		  </td>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span class="small">(0 su 0)</span>') ?>
		  </td>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span class="small">(0 su 0)</span>') ?>
		  </td>
		<?php else: ?>
          <td class="evident"> 
            <b><?php echo number_format($parlamentari->getInt(6)*100/$num_votazioni,2) ?>%</b><br /><span class="small"><?php echo "(".$parlamentari->getInt(6)." su ". $num_votazioni.")" ?></span>
          </td>
          <td class="evident">
            
            <b><?php echo number_format($parlamentari->getInt(7)*100/$num_votazioni,2) ?>%</b><br /><span class="small"><?php echo "(".$parlamentari->getInt(7)." su ". $num_votazioni.")" ?></span>
          </td>
          <td class="evident">
             <b><?php echo number_format($parlamentari->getInt(8)*100/$num_votazioni,2) ?>%</b><br /><span class="small"><?php echo "(".$parlamentari->getInt(8)." su ". $num_votazioni.")" ?></span>
            
          </td>
        <?php endif; ?>
        <?php if($parlamentari->getString(5)!=""): ?>
        <td><span class="small"><?php echo $parlamentari->getString(5) ?></span></td>
         <?php else: ?>
         <td><span class="small"><?php echo '* Senatore a vita' ?></span></td>
        <?php endif; ?>
       <td><p>
       <?php if($parlamentari->getInt(10)!='-1'): ?>
          <?php echo $parlamentari->getInt(13) ?>
       <?php else : ?>
          <?php echo $parlamentari->getInt(14) ?>
       <?php endif; ?>
       </p></td> 
      </tr>
    <?php endwhile; ?>
  </tbody>    
</table>
