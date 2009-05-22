<div class="section-box"> 
            <h3 class="section-box-no-rss">i <?php echo $nome_carica ?> <span style="color:<?php echo $color ?>;"><?php echo $string ?></span></h3> 
            </div> 
<table class="disegni-decreti column-table">
<tbody>	
<?php $tr_class = 'even' ?>				  
<?php while($parlamentari->next()): ?>
   <tr class="<?php echo $tr_class; ?>">
   <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
   <th scope="row">
   <p class="politician-id">
   <?php echo image_tag(OppPoliticoPeer::getThumbUrl($parlamentari->getInt(2)), 
                        array('width' => '40','height' => '53' )) ?>	
    <?php echo link_to($parlamentari->getString(3).' '.$parlamentari->getString(4), '@parlamentare?id='.$parlamentari->getInt(2)) ?>
    <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($parlamentari->getInt(1)) ?>  	
    <?php foreach($gruppi as $nome => $gruppo): ?>
	<?php if(!$gruppo['data_fine']): ?>
	   <?php print" (". $nome.")" ?>
	<?php endif; ?> 
    <?php endforeach; ?> 
    </p>
    </th>
    
     <?php if ($cosa==1) : ?>
        <?php $num_votazioni = $parlamentari->getInt(6) + $parlamentari->getInt(7) + $parlamentari->getInt(8) ?>
        <td>
           <b><?php echo number_format($parlamentari->getInt(6)*100/$num_votazioni,2) ?>%</b><br /><span class="small"><?php echo $parlamentari->getInt(6)." su ". $num_votazioni ?></span>
        </td>  
     <?php elseif ($cosa==2) : ?> 
        <?php $num_votazioni = $parlamentari->getInt(6) + $parlamentari->getInt(7) + $parlamentari->getInt(8) ?>
        <td>
             <b><?php echo number_format($parlamentari->getInt(7)*100/$num_votazioni,2) ?>%</b><br /><span class="small"><?php echo $parlamentari->getInt(7)." su ". $num_votazioni ?></span>
        </td>
     <?php elseif ($cosa==3) : ?> 
        <td>
            <span class="small">indice di attivit&agrave;: </span><?php echo $parlamentari->getFloat(9) ?> 
        </td>   
     <?php elseif ($cosa==4) : ?> 
        <td>
            <span class="small">indice di attivit&agrave;: </span><?php echo $parlamentari->getFloat(9) ?> 
        </td> 
     <?php elseif ($cosa==5) : ?> 
        <td>
             <span class="small">&egrave; monitorato da</span><br/><?php echo $parlamentari->getInt(13) ?><span class="small"> utenti</span>     
        </td> 
     <?php elseif ($cosa==6) : ?> 
        <td>
             <span class="small">voti diversi dal suo gruppo:</span><br/><?php echo $parlamentari->getInt(12) ?><span class="small"> su <?php echo $parlamentari->getInt(6) ?> votazioni</span>
        </td>       
     <?php endif; ?>        
     
    </tr>
    
<?php endwhile; ?>    
 <tr>
 <td>&nbsp;</td>
 <?php if ($quale_pagina==0) : ?> 
    <td><?php echo link_to('vai a tutte le classifiche','/default/classifiche') ?></td>
 <?php else : ?>   
    <?php if ($cosa==1) : ?>
        
        <td>
        
            <?php echo link_to('vai alla classifica',($nome_carica=='deputati') ? '@parlamentari?ramo=camera&sort=presenze&type=desc' : '@parlamentari?ramo=senato&sort=presenze&type=desc') ?>
        </td>  
     <?php elseif ($cosa==2) : ?> 
        <td>
            <?php echo link_to('vai alla classifica',($nome_carica=='deputati') ? '@parlamentari?ramo=camera&sort=assenza&type=desc' :'@parlamentari?ramo=senato&sort=assemze&type=desc') ?> 
        </td> 
     <?php elseif ($cosa==3) : ?> 
        <td>
            <?php echo link_to('vai alla classifica',($nome_carica=='deputati') ? '@parlamentari?ramo=camera&sort=indice&type=desc' :'@parlamentari?ramo=senato&sort=indice&type=desc') ?>
        </td>  
     <?php elseif ($cosa==4) : ?> 
        <td>
            <?php echo link_to('vai alla classifica',($nome_carica=='deputati') ? '@parlamentari?ramo=camera&sort=indice&type=asc' :'@parlamentari?ramo=senato&sort=indice&type=asc') ?>
        </td>  
     <?php elseif ($cosa==5) : ?> 
        <td>
            
        </td>  
     <?php elseif ($cosa==6) : ?> 
        <td>
            <?php echo link_to('vai alla classifica',($nome_carica=='deputati') ? '@parlamentari?ramo=camera&sort=ribelle&type=desc' :'@parlamentari?ramo=senato&sort=ribelle&type=desc') ?>
        </td>      
     <?php endif; ?> 
   <?php endif; ?>            
    </tr>
</tbody>
</table>    
