<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col">parlamentare:</th>
      <th scope="col">gruppo:</th>
      <th scope="col">circoscrizione:</th>				
      <th scope="col" class="evident">presenze:</th>			
      <th scope="col" class="evident">assenze:</th>
      <th scope="col" class="evident">missioni:</th>
      <th scope="col">indice di attivit&agrave;:</th> 
      <th scope="col">voti ribelli:</th>
    </tr>
  </thead>

  <tbody>				  
    <?php while($parlamentari->next()): ?>
      <tr>
        <th scope="row">
          <p class="politician-id">
           <!-- <img width="40" height="55" src="http://openpolis.depplab.net/politician/picture?content_id=<?php echo $parlamentari->getInt(2) ?>" />  --> 
            <?php echo image_tag('no-avatar40.png') ?>	
            <?php echo link_to($parlamentari->getString(3).' '.$parlamentari->getString(4), '@parlamentare?id='.$parlamentari->getInt(2)) ?>
			<?php if($parlamentari->getInt(10)=='-1'): ?>
			<br />cessato il <?php echo format_date($parlamentari->getDate(13, 'Y-m-d'), 'dd/MM/yyyy') ?> 
			<?php endif; ?>
          </p>
        </th>
	    <td>
          <p>	        	
	        <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($parlamentari->getInt(1)) ?>  	
	        <?php foreach($gruppi as $nome => $gruppo): ?>
	          <?php if($gruppo['data_fine']): ?>
              <!--  <?php printf('(dal %s al %s: %s)', format_date($gruppo['data_inizio'], 'dd/MM/yyyy'), format_date($gruppo['data_fine'], 'dd/MM/yyyy'), $nome ) ?> -->
	          <?php else: ?>
		        <?php print $nome ?>
	          <?php endif; ?>
	            <?php print '<br />' ?>
	        <?php endforeach; ?> 
          </p> 			
        </td>
        <td><p><?php echo $parlamentari->getString(5) ?></p></td>
		<?php $num_votazioni = $parlamentari->getInt(6) + $parlamentari->getInt(7) + $parlamentari->getInt(8) ?>
        <?php if($num_votazioni==0): ?>
		  <td class="evident">
		    <?php print('<b>0</b>% (0 su 0)') ?>
		  </td>
		  <td class="evident">
		    <?php print('<b>0</b>% (0 su 0)') ?>
		  </td>
		  <td class="evident">
		    <?php print('<b>0</b>% (0 su 0)') ?>
		  </td>
		<?php else: ?>
          <td class="evident">
            <?php printf('<b>%01.0f</b>%% (%d su %d)', number_format($parlamentari->getInt(6)/$num_votazioni *100,2), $parlamentari->getInt(6), $num_votazioni) ?>
          </td>
          <td class="evident">
            <?php printf('<b>%01.0f</b>%% (%d su %d)', number_format($parlamentari->getInt(7)/$num_votazioni *100,2), $parlamentari->getInt(7), $num_votazioni) ?>
          </td>
          <td class="evident">
            <?php printf('<b>%01.0f</b>%% (%d su %d)', number_format($parlamentari->getInt(8)/$num_votazioni *100,2), $parlamentari->getInt(8), $num_votazioni) ?>
          </td>
        <?php endif; ?>
        <td>
		  <?php if($parlamentari->getInt(10)!='-1'): ?>
            <?php printf('<b>%01.2f</b>', $parlamentari->getFloat(9), $parlamentari->getInt(10), $numero_parlamentari) ?> 
       <!--     <?php printf('<b>%01.2f</b> (%d° su %d)', $parlamentari->getFloat(9), $parlamentari->getInt(10), $numero_parlamentari) ?>  --> 
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
      </tr>
    <?php endwhile; ?>
  </tbody>    
</table>