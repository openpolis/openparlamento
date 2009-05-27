<?php if($atto->countOppDocumentos() != 0): ?>

<div class="coo-mind float-container">
  <h5 class="subsection">leggi e annota i testi di questo <?php echo $tipo_atto ?> :</h5>
  <table>
    <thead>
      <tr> 
        <th scope="col">&nbsp;</th>
        <th scope="col">n. annotazioni <?php echo image_tag('ico-coo-mind.png', array('alt' => 'coo-mind' )) ?></th>
      </tr>
    </thead>
    <!-- per activity-meter la larghezza max e' 75px ....
         per calcolare la larghezza si potrebbe stabilire che e' pari al 100% (75px) quando maggiore di N annotazioni (es: 30)
         o meglio si potrebbe calcolare un indice di attivita' tipo quello dei parlamentari	-->
    <tbody>
      <?php $i=1 ?>	
      <?php foreach($documenti as $documento): ?> 
	    <?php if($limit_count < $limit): ?>    
          <tr>
            <th><?php echo link_to('<strong>'.$i.'</strong>&nbsp;'.$documento->getTitolo(), 'atto/documento?id='.$documento->getId() ) ?></th>
            <td>
            <?php $num_comm=count(sfEmendCommentPeer::getAllCommentsForResource('atto_documento_id_'.$documento->getId())) ?>
            <?php echo link_to($num_comm,'atto/documento?id='.$documento->getId()) ?>
            <?php switch($num_comm) : 
               case 0 : 
                  $actvitity=0; 
                  break; 
               case $num_comm<6 : 
                  $actvitity=15; 
                  break;  
               case $num_comm<11 : 
                  $actvitity=20; 
                  break;  
               case $num_comm<16 : 
                  $actvitity=30; 
                  break;      
               case $num_comm<21 : 
                  $actvitity=45; 
                  break;       
               case $num_comm<26 : 
                  $actvitity=60; 
                  break;  
               case $num_comm>30 : 
                  $actvitity=75; 
                  break;   ?>   
             <?php endswitch ?>                    
            <span class="activity-meter" style="width: <?php echo $actvitity ?>px;">&nbsp;</span></td>
          </tr>
          <?php $limit_count++; ?>
		  <?php $i++ ?>
        <?php else: ?>
          <?php break; ?>  	  
        <?php endif; ?>
	  <?php endforeach; ?>
    </tbody>
  </table>
  
  <?php if($documenti_count > $limit): ?>
  
    <p class="indent">guarda tutti gli altri <strong><?php echo ($documenti_count - $limit) ?> </strong> testi del <?php echo $tipo_atto ?>...
      [ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]<br /><br />
    </p>  
    <div class="more-results float-container" style="display: none;">
      <table>
        <thead>
          <tr style="visibility: hidden;">
            <th scope="col">titolo</th>
            <th scope="col">n. annotazioni <img src="imgs/ico-coo-mind.png" alt="coo-mind" /></th>
          </tr>
        </thead>
          <!-- per activity-meter la larghezza max e' 75px ....
               per calcolare la larghezza si potrebbe stabilire che e' pari al 100% (75px) quando maggiore di N commenti (es: 30)
               o meglio si potrebbe calcolare un indice di attivita' tipo quello dei parlamentari -->
        <tbody>
          <?php $limit_count = 0; ?> 
          <?php foreach($documenti as $documento): ?>
	        <?php if ($limit_count >= $limit): ?>	   		
              <tr>
                <th><?php echo link_to('<strong>'.$i.'</strong>&nbsp;'.$documento->getTitolo(), 'atto/documento?id='.$documento->getId() ) ?></th>
            <td>
            <?php $num_comm=count(sfEmendCommentPeer::getAllCommentsForResource('atto_documento_id_'.$documento->getId())) ?>
            <?php echo link_to($num_comm,'atto/documento?id='.$documento->getId()) ?>
            <?php switch($num_comm) : 
               case 0 : 
                  $actvitity=0; 
                  break; 
               case $num_comm<6 : 
                  $actvitity=15; 
                  break;  
               case $num_comm<11 : 
                  $actvitity=20; 
                  break;  
               case $num_comm<16 : 
                  $actvitity=30; 
                  break;      
               case $num_comm<21 : 
                  $actvitity=45; 
                  break;       
               case $num_comm<26 : 
                  $actvitity=60; 
                  break;  
               case $num_comm>30 : 
                  $actvitity=75; 
                  break;   ?>   
             <?php endswitch ?>                    
            <span class="activity-meter" style="width: <?php echo $actvitity ?>px;">&nbsp;</span></td>
              </tr>
			  <?php $i++ ?>
            <?php else: ?>
              <?php $limit_count++; ?>  	  
            <?php endif; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="more-results-close">[ <?php echo link_to('chiudi', '#', array('class'=>'btn-close action') ) ?> ]</div>
    </div>
  
  <?php endif; ?> 			
</div>

<?php endif; ?>  