<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col">parlamentare:</th>
      <th scope="col">indice di attivit&agrave;:</th> 	
      <th scope="col">voti ribelli:</th>			
      <th scope="col" class="evident">presenze:</th>			
      <th scope="col" class="evident">assenze:</th>
      <th scope="col" class="evident">missioni:</th>
      <th scope="col">circoscrizione:</th>
    </tr>
  </thead>

  <tbody>				  
    <?php while($parlamentari->next()): ?>
      <tr>
        <th scope="row">
          <p class="politician-id">
            <?php echo image_tag(OppPoliticoPeer::getThumbUrl($parlamentari->getInt(2)), 
                                 'icona parlamentare') ?>	
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
          </p>
        </th>
        
        <td>
		  <?php if($parlamentari->getInt(10)!='-1'): ?>
                   <?php printf('<b>%01.2f</b><br /><span style="font-size:11px; color:#888888">(%d° su %d)</span>', $parlamentari->getFloat(9), $parlamentari->getInt(10), $numero_parlamentari) ?> 
                  <?php else: ?>
		    <?php printf('<b>%01.2f</b> ', $parlamentari->getFloat(9)) ?>  
		  <?php endif; ?>
	</td>
        
        <td>
          <?php if($parlamentari->getInt(6)!=0 && $parlamentari->getInt(12)!=0): ?>
            <?php printf('<b>%01.2f</b>%%', number_format($parlamentari->getInt(12)/$parlamentari->getInt(6) *100,2), $parlamentari->getInt(12), $parlamentari->getInt(6)) ?>
              <!--  <?php printf('<b>%01.2f</b>%% (%d su %d)', number_format($parlamentari->getInt(12)/$parlamentari->getInt(6) *100,2), $parlamentari->getInt(12), $parlamentari->getInt(6)) ?> -->
	      <?php else: ?>
	        <?php print('<b>0</b>% ') ?>
	      <!--   <?php print('<b>0</b>% (0 su 0)') ?> -->
	      <?php endif; ?>
        </td>    
        
	<?php $num_votazioni = $parlamentari->getInt(6) + $parlamentari->getInt(7) + $parlamentari->getInt(8) ?>
        <?php if($num_votazioni==0): ?>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span style="font-size:11px; color:#888888">(0 su 0)</span>') ?>
		  </td>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span style="font-size:11px; color:#888888">(0 su 0)</span>') ?>
		  </td>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span style="font-size:11px; color:#888888">(0 su 0)</span>') ?>
		  </td>
		<?php else: ?>
          <td class="evident">
            <?php printf('<b>%01.0f</b>%% <br /><span style="font-size:11px; color:#888888">(%d su %d)</span>', number_format($parlamentari->getInt(6)/$num_votazioni *100,2), $parlamentari->getInt(6), $num_votazioni) ?>
          </td>
          <td class="evident">
            <?php printf('<b>%01.0f</b>%% <br /><span style="font-size:11px; color:#888888">(%d su %d)</span>', number_format($parlamentari->getInt(7)/$num_votazioni *100,2), $parlamentari->getInt(7), $num_votazioni) ?>
          </td>
          <td class="evident">
            <?php printf('<b>%01.0f</b>%% <br /><span style="font-size:11px; color:#888888">(%d su %d)</span>', number_format($parlamentari->getInt(8)/$num_votazioni *100,2), $parlamentari->getInt(8), $num_votazioni) ?>
          </td>
        <?php endif; ?>
        <?php if($parlamentari->getString(5)!=""): ?>
        <td><p><?php echo $parlamentari->getString(5) ?></p></td>
         <?php else: ?>
         <td><p><?php echo '* Senatore a vita' ?></p></td>
        <?php endif; ?>
        
      </tr>
    <?php endwhile; ?>
  </tbody>    
</table>